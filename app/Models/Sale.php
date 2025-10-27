<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    // Payment method constants
    public const PAYMENT_CASH = 'cash';
    public const PAYMENT_GCASH = 'gcash';
    public const PAYMENT_METHODS = [
        self::PAYMENT_CASH,
        self::PAYMENT_GCASH,
    ];

    protected $table = 'sales';

    protected $fillable = [
        'sales_number',
        'branch_id',
        'employee_id',
        'customer_id',          // optional FK to customers table
        'status',               // draft|reserved|completed|cancelled
        'sub_total',
        'tax_total',
        'discount_total',
        'grand_total',
        'sold_at',
        // payment fields
        'payment_method',       // 'cash'|'gcash'
        'payment_reference',    // e.g. gcash transaction ref or manual note
        'amount_paid',       // optional explicit amount paid
        'change',
        // audit
        'createdby_id',
        'updatedby_id',
    ];

    protected $casts = [
        'sub_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    /**********************
     * Relationships
     **********************/
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'createdby_id', 'employee_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updatedby_id', 'employee_id');
    }

    /**********************
     * Helpers / Business logic
     **********************/
    /**
     * Recalculate totals from the sale items and save.
     */
    public function recalcTotals(): self
    {
        $sub = $this->items()->get()->sum('line_total');
        $this->sub_total = $sub;
        $this->grand_total = $sub + ($this->tax_total ?? 0) - ($this->discount_total ?? 0);
        $this->save();
        return $this->refresh();
    }

    /**
     * Mark sale as completed and record payment info.
     *
     * @param  string $paymentMethod one of PAYMENT_METHODS
     * @param  string|null $reference
     * @param  float|null $amount
     * @param  int|null $employeeId
     */
    public function complete(string $paymentMethod = self::PAYMENT_CASH, ?string $reference = null, ?float $amount = null, ?int $employeeId = null): self
    {
        if (! in_array($paymentMethod, self::PAYMENT_METHODS)) {
            throw new \InvalidArgumentException("Unsupported payment method: {$paymentMethod}");
        }

        // ensure totals are recalculated first
        $this->recalcTotals();

        $this->status = 'completed';
        $this->sold_at = now();
        $this->payment_method = $paymentMethod;
        $this->payment_reference = $reference;
        $this->payment_amount = $amount ?? $this->grand_total;
        $this->updatedby_id = $employeeId ?? $this->updatedby_id;
        $this->save();

        return $this->refresh();
    }

    /**
     * Mark sale as reserved (e.g., hold inventory)
     */
    public function reserve(?int $employeeId = null): self
    {
        $this->status = 'reserved';
        $this->updatedby_id = $employeeId ?? $this->updatedby_id;
        $this->save();
        return $this->refresh();
    }

    /**
     * Mark sale as cancelled and optionally release inventory logic should run externally.
     */
    public function cancel(?int $employeeId = null): self
    {
        $this->status = 'cancelled';
        $this->updatedby_id = $employeeId ?? $this->updatedby_id;
        $this->save();
        return $this->refresh();
    }

    /**********************
     * Scopes
     **********************/
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }
}
