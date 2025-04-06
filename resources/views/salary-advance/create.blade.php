@extends('layouts.app')

@section('title', 'New Salary Advance Request')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-lg leading-6 font-medium text-gray-900">New Salary Advance Request</h1>
            <p class="mt-1 text-sm text-gray-500">
                Please fill in the details below to submit your salary advance request.
            </p>
        </div>

        <div class="border-t border-gray-200">
            <form action="{{ route('salary-advance.store') }}" method="POST" class="divide-y divide-gray-200">
                @csrf

                @if($errors->has('general'))
                    <div class="px-4 py-3 bg-red-50">
                        <p class="text-sm text-red-600">{{ $errors->first('general') }}</p>
                    </div>
                @endif

                <div class="px-4 py-5 space-y-6 sm:p-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">
                            Amount (LKR)
                        </label>
                        <div class="mt-1">
                            <input type="number" name="amount" id="amount"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                min="1000" max="{{ config('app.max_advance_amount') }}" step="100"
                                value="{{ old('amount') }}" required>
                        </div>
                        @error('amount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            Minimum: LKR 1,000 | Maximum: LKR {{ number_format(config('app.max_advance_amount')) }}
                        </p>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">
                            Reason for Request
                        </label>
                        <div class="mt-1">
                            <textarea id="reason" name="reason" rows="4"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                required>{{ old('reason') }}</textarea>
                        </div>
                        @error('reason')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            Please provide a detailed explanation for your advance request.
                        </p>
                    </div>

                    <!-- Needed By Date -->
                    <div>
                        <label for="needed_by_date" class="block text-sm font-medium text-gray-700">
                            Needed By Date
                        </label>
                        <div class="mt-1">
                            <input type="date" name="needed_by_date" id="needed_by_date"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                max="{{ date('Y-m-d', strtotime('+1 month')) }}"
                                value="{{ old('needed_by_date') }}" required>
                        </div>
                        @error('needed_by_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            Must be between tomorrow and one month from today.
                        </p>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a href="{{ route('employee.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 