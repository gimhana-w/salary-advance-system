<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmployeeProfileRequest;
use App\Models\Employee;
use App\Models\SalaryAdvanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $employee = auth()->user();
        $pendingRequests = $employee->salaryAdvanceRequests()
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $recentRequests = $employee->salaryAdvanceRequests()
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('employee.dashboard', compact('pendingRequests', 'recentRequests'));
    }

    public function profile()
    {
        return view('employee.profile', ['employee' => auth()->user()]);
    }

    public function updateProfile(UpdateEmployeeProfileRequest $request)
    {
        $employee = auth()->user();
        
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        
        if ($request->filled('new_password')) {
            $employee->password = Hash::make($request->new_password);
        }
        
        $employee->save();

        return back()->with('status', 'Profile updated successfully.');
    }

    public function requestHistory()
    {
        $requests = auth()->user()->salaryAdvanceRequests()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.request-history', compact('requests'));
    }

    public function deleteEmployee($id)
    {
        $request = SalaryAdvanceRequest::findOrFail($id);
        $request->delete();

        return redirect()->back()->with('success', 'Request deleted successfully.');
    }
}
