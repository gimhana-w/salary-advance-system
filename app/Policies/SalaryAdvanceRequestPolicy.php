<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\SalaryAdvanceRequest;

class SalaryAdvanceRequestPolicy
{
    public function view(Employee $employee, SalaryAdvanceRequest $request)
    {
        return $employee->is_admin || $employee->id === $request->employee_id;
    }

    public function approve(Employee $employee, SalaryAdvanceRequest $request)
    {
        return $employee->is_admin && $request->status === 'pending';
    }

    public function reject(Employee $employee, SalaryAdvanceRequest $request)
    {
        return $employee->is_admin && $request->status === 'pending';
    }
} 