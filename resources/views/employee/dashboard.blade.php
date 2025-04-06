@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <a href="{{ route('salary-advance.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            New Advance Request
        </a>
    </div>

    <!-- Pending Requests -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Pending Requests</h2>
        </div>
        @if($pendingRequests->count() > 0)
            <div class="border-t border-gray-200">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($pendingRequests as $request)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">
                                        Amount: LKR {{ number_format($request->amount, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Needed by: {{ $request->needed_by_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="px-4 py-5 sm:px-6 text-gray-500">
                No pending requests.
            </div>
        @endif
    </div>

    <!-- Recent Requests -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Recent Requests</h2>
        </div>
        @if($recentRequests->count() > 0)
            <div class="border-t border-gray-200">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($recentRequests as $request)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">
                                        Amount: LKR {{ number_format($request->amount, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Submitted: {{ $request->created_at->format('M d, Y') }}
                                    </p>
                                    @if($request->rejection_reason)
                                        <p class="text-sm text-red-600 mt-1">
                                            Reason: {{ $request->rejection_reason }}
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    @if($request->isApproved())
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
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="px-4 py-5 sm:px-6 text-gray-500">
                No recent requests.
            </div>
        @endif
    </div>
</div>
@endsection 