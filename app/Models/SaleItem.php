<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleItem extends Model
{
    use HasFactory;

    protected $table = 'sale_items';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'line_discount',
        'tax',
        'line_total',
        'is_serialized',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'line_discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'line_total' => 'decimal:2',
        'is_serialized' => 'boolean',
    ];

    /**********************
     * Relations
     **********************/
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Inventory items assigned to this sale item (serialized rows)
     */
    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class, 'sale_item_id', 'id');
    }

    /**********************
     * Helpers
     **********************/
    /**
     * Recalculate this line's totals from quantity/unit_price/discount/tax and save.
     */
    public function recalcLine(): self
    {
        $base = (float) $this->unit_price * (int) $this->quantity;
        $discount = (float) $this->line_discount;
        $tax = (float) $this->tax;
        $this->line_total = $base - $discount + $tax;
        $this->save();
        return $this->refresh();
    }
}
