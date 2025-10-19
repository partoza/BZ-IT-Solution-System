<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'branch_id';

    /**
     * Disable automatic timestamps since we have custom ones
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
    ];

    /**
     * Get the employees for the branch.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'branch_id', 'branch_id');
    }

    /**
     * Get the employees created by this branch's employees.
     */
    public function createdEmployees(): HasMany
    {
        return $this->hasMany(Employee::class, 'createdby_id', 'employee_id');
    }

    /**
     * Get the branch name with location.
     */
    public function getFullNameAttribute(): string
    {
        return $this->location ? "{$this->name} - {$this->location}" : $this->name;
    }
}