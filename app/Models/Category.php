<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',      
        'image',             
        'parent_id',
        'warranty_allowed', 
        'category_type',  
        'status',   
        'createdby_id',
        'updatedby_id',
    ];

    protected $casts = [
         'warranty_allowed' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function subProducts()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
}
