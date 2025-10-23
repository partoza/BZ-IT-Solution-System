<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryItem;

class Product extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_name',
        'description',
        'category_id',
        'sub_category_id',
        'brand_id',
        'image',
        'active_status',
        'base_price',
        'discounted_price',
        'warranty_period',
        'createdby_id',
        'updatedby_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'active_status' => 'boolean',
        'base_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
    ];

    /**
     * Automatically set createdby_id and updatedby_id
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

    // A product belongs to one category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // A product may also belong to a sub-category
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    // A product belongs to a brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Created by employee
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'createdby_id');
    }

    // Updated by employee
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updatedby_id');
    }

    // A product can belong to many branches (pivot table)
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'branch_product', 'product_id', 'branch_id')
                    ->withPivot(['quantity_in_stock', 'low_stock_threshold', 'medium_stock_threshold', 'override_price'])
                    ->withTimestamps();
                    
    }

    /**
     * Accessors / Helper methods
     */

    // Get final price (consider discounted price if available)
    public function getFinalPriceAttribute(): float
    {
        return $this->discounted_price ?? $this->base_price;
    }

    // Get formatted price (useful for UI)
    public function getFormattedPriceAttribute(): string
    {
        return '₱' . number_format($this->final_price, 2);
    }

    // Simple image URL accessor (assumes using Laravel storage)
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/img/default-product.png');
    }

    // Helper: check if product has warranty
    public function getHasWarrantyAttribute(): bool
    {
        return !empty($this->warranty_period);
    }

    /**
     * Scopes
     */

    // Only active products
    public function scopeActive($query)
    {
        return $query->where('active_status', true);
    }

    // Filter by category
    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class, 'product_id', 'product_id');
    }
    
    public function stockCount($branchId)
    {
        return $this->inventoryItems()->where('branch_id', $branchId)->where('status', 'in_stock')->count();
    }

    public function currentPrice($branchId)
    {
        // Latest inventory item for the branch
        $item = $this->inventoryItems()
                    ->where('branch_id', $branchId)
                    ->where('status', 'in_stock')
                    ->latest('created_at')
                    ->first();

        return $item ? $item->unit_price : $this->base_price;
    }
}
