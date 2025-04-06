@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-lg leading-6 font-medium text-gray-900">Profile Information</h1>
            <p class="mt-1 text-sm text-gray-500">
                Update your personal information and password.
            </p>
        </div>

        <div class="border-t border-gray-200">
            <form action="{{ route('employee.profile.update') }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')

                <div class="px-4 py-5 space-y-6 sm:p-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Name
                        </label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('name', $employee->name) }}" required>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('email', $employee->email) }}" required>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">
                            Phone Number
                        </label>
                        <div class="mt-1">
                            <input type="text" name="phone_number" id="phone_number"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('phone_number', $employee->phone_number) }}" required>
                        </div>
                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee Information -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Employee ID
                            </label>
                            <div class="mt-1">
                                <input type="text" disabled
                                    class="bg-gray-50 shadow-sm block w-full sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $employee->employee_id }}">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Department
                            </label>
                            <div class="mt-1">
                                <input type="text" disabled
                                    class="bg-gray-50 shadow-sm block w-full sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $employee->department }}">
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                Current Password
                            </label>
                            <div class="mt-1">
                                <input type="password" name="current_password" id="current_password"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">
                                New Password
                            </label>
                            <div class="mt-1">
                                <input type="password" name="new_password" id="new_password"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('new_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirm New Password
                            </label>
                            <div class="mt-1">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 