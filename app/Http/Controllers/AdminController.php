<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\SalaryAdvanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingRequests = SalaryAdvanceRequest::with('employee')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $recentlyApproved = SalaryAdvanceRequest::with(['employee', 'approver'])
            ->where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->take(5)
            ->get();

        $totalEmployees = Employee::count();
        $totalPendingRequests = $pendingRequests->count();
        $totalApprovedThisMonth = SalaryAdvanceRequest::where('status', 'approved')
            ->whereMonth('approved_at', now())
            ->count();

        return view('admin.dashboard', compact(
            'pendingRequests',
            'recentlyApproved',
            'totalEmployees',
            'totalPendingRequests',
            'totalApprovedThisMonth'
        ));
    }

    public function employees()
    {
        $employees = Employee::orderBy('name')->paginate(10);
        $departments = Employee::distinct()->pluck('department');
        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function createEmployee()
    {
        return view('admin.employees.create');
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:8',
            'employee_id' => 'required|string|unique:employees',
            'nic' => 'required|string|unique:employees',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee_id' => $request->employee_id,
            'nic' => $request->nic,
            'department' => 'Pending',
            'position' => 'Pending',
            'base_salary' => 0,
            'phone_number' => '',
            'emergency_contact' => '',
            'address' => '',
            'bank_account_no' => '',
            'bank_name' => '',
            'is_admin' => false,
            'is_active' => true,
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee account created successfully. The employee can now log in and complete their profile.');
    }

    public function editEmployee(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function updateEmployee(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'employee_id' => 'required|string|unique:employees,employee_id,' . $employee->id,
            'nic' => 'required|string|unique:employees,nic,' . $employee->id,
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
            'phone_number' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $employee->update($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function deleteEmployee(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function requests()
    {
        $requests = SalaryAdvanceRequest::with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.requests', compact('requests'));
    }

    public function approveRequest(SalaryAdvanceRequest $request)
    {
        $request->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('status', 'Request approved successfully.');
    }

    public function rejectRequest(Request $request, SalaryAdvanceRequest $advanceRequest)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $advanceRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
        ]);

        return back()->with('status', 'Request rejected successfully.');
    }

    public function reports()
    {
        $monthlyStats = SalaryAdvanceRequest::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total_requests,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_requests,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_requests,
            AVG(CASE WHEN status = "approved" THEN amount ELSE NULL END) as avg_approved_amount
        ')
        ->groupBy('year', 'month')
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->take(12)
        ->get();

        $departmentStats = Employee::selectRaw('
            department,
            COUNT(DISTINCT employees.id) as total_employees,
            COUNT(DISTINCT sar.id) as total_requests,
            SUM(CASE WHEN sar.status = "approved" THEN 1 ELSE 0 END) as approved_requests
        ')
        ->leftJoin('salary_advance_requests as sar', 'employees.id', '=', 'sar.employee_id')
        ->groupBy('department')
        ->get();

        return view('admin.reports', compact('monthlyStats', 'departmentStats'));
    }
}
