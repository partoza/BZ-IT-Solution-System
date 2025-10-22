<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    use HasFactory;

    protected $table = 'branch_product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'branch_id',
        'product_id',
        'quantity_in_stock',
        'low_stock_threshold',
        'medium_stock_threshold',
        'override_price',
    ];
}
