<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'product_id',
        'branch_id',
        'purchase_order_item_id',
        'serial_number',
        'unit_price',
        'status', // 'in_stock', 'reserved', 'sold', 'returned'
        'sale_id',
        'sale_item_id',
        'sold_price',
        'sold_at',
        'createdby_id',
        'updatedby_id',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'unit_price'   => 'decimal:2',
        'sold_price'   => 'decimal:2',
        'sold_at'      => 'datetime',
    ];

    /**
     * Automatically set createdby_id and updatedby_id using employee guard
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::guard('employee')->check()) {
                $model->createdby_id = Auth::guard('employee')->user()->employee_id;
            }
        });

        static::updating(function ($model) {
            if (Auth::guard('employee')->check()) {
                $model->updatedby_id = Auth::guard('employee')->user()->employee_id;
            }
        });
    }

    /**
     * Relationships
     */

    // Each inventory item belongs to a product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Each inventory item belongs to a branch
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    // Link to purchase order item (if any)
    public function purchaseOrderItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_item_id', 'id');
    }

    // Link to the sale header that consumed this item (nullable)
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    // Link to the sale item line that consumed this item (nullable)
    public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class, 'sale_item_id', 'id');
    }

    // Created/updated by employee
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'createdby_id', 'employee_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updatedby_id', 'employee_id');
    }

    /**
     * Scopes
     */

    /**
     * Items that are currently in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('status', 'in_stock');
    }

    /**
     * Items available for sale/reservation
     */
    public function scopeAvailableForSale($query)
    {
        return $query->whereIn('status', ['in_stock', 'reserved']);
    }

    /**
     * Convenience methods
     */

    /**
     * Mark this inventory item as sold and attach sale references.
     *
     * @param  int|null  $saleId
     * @param  int|null  $saleItemId
     * @param  float|null $soldPrice
     * @param  int|null $employeeId
     * @return $this
     */
    public function markSold($saleId = null, $saleItemId = null, $soldPrice = null, $employeeId = null)
    {
        $this->status = 'sold';
        $this->sale_id = $saleId;
        $this->sale_item_id = $saleItemId;
        $this->sold_price = $soldPrice ?? $this->unit_price;
        $this->sold_at = now();
        $this->updatedby_id = $employeeId ?? $this->detectEmployeeId();
        $this->save();

        return $this;
    }

    /**
     * Mark this inventory item as reserved (e.g., hold for pending payment).
     *
     * @param  int|null $saleId
     * @param  int|null $saleItemId
     * @param  int|null $employeeId
     * @return $this
     */
    public function markReserved($saleId = null, $saleItemId = null, $employeeId = null)
    {
        $this->status = 'reserved';
        $this->sale_id = $saleId;
        $this->sale_item_id = $saleItemId;
        $this->updatedby_id = $employeeId ?? $this->detectEmployeeId();
        $this->save();

        return $this;
    }

    /**
     * Mark this inventory item as returned (or restocked depending on business logic).
     *
     * @param  int|null $employeeId
     * @param  bool $restock  if true, set status to 'in_stock' after inspection
     * @return $this
     */
    public function markReturned($employeeId = null, $restock = false)
    {
        $this->status = $restock ? 'in_stock' : 'returned';
        // keep sale_id for audit; optionally null it if you want to detach
        $this->updatedby_id = $employeeId ?? $this->detectEmployeeId();
        $this->save();

        return $this;
    }

    /**
     * Assign a serial number to this row. Ensures uniqueness.
     *
     * Use this when you created placeholder rows for bulk PO and want to set serials later.
     *
     * @param  string $serial
     * @return $this
     * @throws Exception
     */
    public function assignSerial(string $serial)
    {
        $serial = trim($serial);
        if ($serial === '') {
            throw new Exception('Serial cannot be empty.');
        }

        // check uniqueness across inventory_items
        $exists = self::where('serial_number', $serial)->where('id', '!=', $this->id)->exists();
        if ($exists) {
            throw new Exception("Serial number '{$serial}' already exists.");
        }

        $this->serial_number = $serial;
        $this->save();

        return $this;
    }

    /**
     * Helper: try to detect employee id from guard if not provided
     *
     * @return int|null
     */
    protected function detectEmployeeId()
    {
        if (Auth::guard('employee')->check()) {
            return Auth::guard('employee')->user()->employee_id;
        }
        return null;
    }
}
