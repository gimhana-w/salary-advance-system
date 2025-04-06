<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'nic',
        'department',
        'position',
        'base_salary',
        'phone_number',
        'join_date',
        'emergency_contact',
        'address',
        'bank_account_no',
        'bank_name',
        'is_admin',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'base_salary' => 'decimal:2',
        'join_date' => 'date',
    ];

    public function salaryAdvanceRequests()
    {
        return $this->hasMany(SalaryAdvanceRequest::class);
    }

    public function approvedRequests()
    {
        return $this->hasMany(SalaryAdvanceRequest::class, 'approved_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
