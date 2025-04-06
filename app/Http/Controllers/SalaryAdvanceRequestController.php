<?php

namespace App\Http\Controllers;

use App\Http\Requests\RejectSalaryAdvanceRequest;
use App\Http\Requests\StoreSalaryAdvanceRequest;
use App\Models\SalaryAdvanceRequest;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;

class SalaryAdvanceRequestController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function create()
    {
        return view('salary-advance.create');
    }

    public function store(StoreSalaryAdvanceRequest $request)
    {
        $employee = Auth::user();
        
        // Check if employee has any pending requests
        if ($employee->advanceRequests()->where('status', 'pending')->exists()) {
            return back()->withErrors(['general' => 'You already have a pending advance request.']);
        }

        // Check cooldown period
        $lastApprovedRequest = $employee->advanceRequests()
            ->where('status', 'approved')
            ->latest('approved_at')
            ->first();

        if ($lastApprovedRequest && $lastApprovedRequest->approved_at->addDays(config('app.advance_request_cooldown_days'))->isFuture()) {
            return back()->withErrors(['general' => 'You must wait ' . config('app.advance_request_cooldown_days') . ' days between advance requests.']);
        }

        // Create the request
        $advanceRequest = new SalaryAdvanceRequest($request->validated());
        $employee->advanceRequests()->save($advanceRequest);

        return redirect()->route('employee.dashboard')
            ->with('status', 'Salary advance request submitted successfully.');
    }

    public function show(SalaryAdvanceRequest $request)
    {
        $this->authorize('view', $request);
        return view('salary-advance.show', compact('request'));
    }

    public function approve(SalaryAdvanceRequest $advanceRequest)
    {
        $this->authorize('approve', $advanceRequest);

        if (!$advanceRequest->isPending()) {
            return back()->withErrors(['status' => 'This request cannot be approved.']);
        }

        $advanceRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Send SMS notification
        $this->smsService->sendAdvanceRequestApproval(
            $advanceRequest->employee->phone_number,
            $advanceRequest->amount
        );

        return back()->with('status', 'Salary advance request approved successfully.');
    }

    public function reject(RejectSalaryAdvanceRequest $request, SalaryAdvanceRequest $advanceRequest)
    {
        $this->authorize('reject', $advanceRequest);

        if (!$advanceRequest->isPending()) {
            return back()->withErrors(['status' => 'This request cannot be rejected.']);
        }

        $advanceRequest->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Send SMS notification
        $this->smsService->sendAdvanceRequestRejection(
            $advanceRequest->employee->phone_number,
            $request->rejection_reason
        );

        return back()->with('status', 'Salary advance request rejected successfully.');
    }
}
