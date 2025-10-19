<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'employee_id';

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
        'branch_id',
        'first_name',
        'last_name',
        'role',
        'avatar',
        'phone_number',
        'email_address',
        'username',
        'password',
        'active_status',
        'createdby_id',
        'updatedby_id',
        'created_date', // Add this
        'updated_date', // Add this
        'last_login',   // Add this
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login' => 'datetime',
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'active_status' => 'boolean',
    ];

    /**
     * Get the email address for the user (for authentication).
     */
    public function getEmailAttribute(): string
    {
        return $this->email_address;
    }

    /**
     * Get the branch that the employee belongs to.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    /**
     * Get the employee who created this employee record.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'createdby_id', 'employee_id');
    }

    /**
     * Get the employee who last updated this employee record.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updatedby_id', 'employee_id');
    }

    /**
     * Get the employees created by this employee.
     */
    public function createdEmployees(): HasMany
    {
        return $this->hasMany(Employee::class, 'createdby_id', 'employee_id');
    }

    /**
     * Get the employees updated by this employee.
     */
    public function updatedEmployees(): HasMany
    {
        return $this->hasMany(Employee::class, 'updatedby_id', 'employee_id');
    }

    /**
     * Get the full name of the employee.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('active_status', true);
    }

    /**
     * Scope a query to only include employees of a specific role.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}