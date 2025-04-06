@extends('layouts.app')

@section('title', 'Request Details')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="px-4 sm:px-0 mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Salary Advance Request Details</h1>
        <div>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.requests') }}"
                    class="text-blue-600 hover:text-blue-900">← Back to Requests</a>
            @else
                <a href="{{ route('employee.requests') }}"
                    class="text-blue-600 hover:text-blue-900">← Back to My Requests</a>
            @endif
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Request #{{ $request->id }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Submitted on {{ $request->created_at->format('M d, Y \a\t H:i') }}
                    </p>
                </div>
                <div>
                    @if($request->isPending())
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @elseif($request->isApproved())
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Approved
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Rejected
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Employee Name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $request->employee->name }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Employee ID
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $request->employee->employee_id }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Department
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $request->employee->department }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Amount Requested
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        LKR {{ number_format($request->amount, 2) }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Needed By Date
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $request->needed_by_date->format('M d, Y') }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Reason for Request
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $request->reason }}
                    </dd>
                </div>
                @if($request->isApproved())
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Approved By
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $request->approver->name }} on {{ $request->approved_at->format('M d, Y \a\t H:i') }}
                        </dd>
                    </div>
                @elseif($request->isRejected())
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Rejection Reason
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $request->rejection_reason }}
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
        @if(auth()->user()->isAdmin() && $request->isPending())
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                <button onclick="approveRequest({{ $request->id }})"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mr-3">
                    Approve Request
                </button>
                <button onclick="showRejectModal({{ $request->id }})"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Reject Request
                </button>
            </div>
        @endif
    </div>
</div>

@if(auth()->user()->isAdmin())
    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Reject Request</h3>
                        <form id="rejectForm" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                                <textarea name="rejection_reason" id="rejection_reason" rows="3" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Reject Request
                                </button>
                                <button type="button"
                                    onclick="document.getElementById('rejectModal').classList.add('hidden')"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function approveRequest(id) {
            if (confirm('Are you sure you want to approve this request?')) {
                fetch(`/admin/requests/${id}/approve`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            }
        }

        function showRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/requests/${id}/reject`;
            modal.classList.remove('hidden');
        }
    </script>
    @endpush
@endif
@endsection 