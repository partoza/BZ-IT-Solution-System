<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'serial_number',
        'unit_price',
        'status', // e.g., 'in_stock', 'sold', 'reserved'
        'createdby_id',
        'updatedby_id',
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

    // Each inventory item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Each inventory item belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    // Created/updated by employee
    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'createdby_id', 'employee_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Employee::class, 'updatedby_id', 'employee_id');
    }
}
