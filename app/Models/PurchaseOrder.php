<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'po_number',
        'status',
        'order_date',
        'expected_date',
        'received_date',
        'notes',
        'createdby_id',
        'updatedby_id',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'expected_date' => 'datetime',
        'received_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
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

    /** Relationships **/

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'createdby_id');
    }

    public function updater()
    {
        return $this->belongsTo(Employee::class, 'updatedby_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
