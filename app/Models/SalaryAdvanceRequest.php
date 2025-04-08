<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAdvanceRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'amount',
        'reason',
        'needed_by_date',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'is_deduct_from_salary',
        'created_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'needed_by_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'is_deduct_from_salary' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(Employee::class, 'rejected_by');
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
