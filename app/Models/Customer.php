<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // create this table via migration (example below)

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone_number',
        'address',
        'notes',
        'createdby_id',
        'updatedby_id',
    ];

    /**********************
     * Relations
     **********************/
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'createdby_id', 'employee_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updatedby_id', 'employee_id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }
}
