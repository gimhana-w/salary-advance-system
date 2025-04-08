@extends('layouts.app')

@section('title', 'Employee Management')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Employee Management</h1>
        <button type="button" onclick="document.getElementById('addEmployeeModal').classList.remove('hidden')"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Add Employee
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-4 rounded-lg shadow">
        <form action="{{ route('admin.employees.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    placeholder="Name or Employee ID">
            </div>
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                <select name="department" id="department"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-gray-100 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filter Results
                </button>
            </div>
        </form>
    </div>

    <!-- Employee List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Employee ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            NIC
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Position
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Base Salary
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($employees as $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $employee->employee_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $employee->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $employee->nic }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $employee->department }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $employee->position }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($employee->base_salary, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="document.getElementById('editEmployeeModal').classList.remove('hidden'); document.getElementById('editEmployeeId').value = {{ $employee->id }};"
                                    class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                <button onclick="deleteEmployee({{ $employee->id }})"
                                    class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            {{ $employees->links() }}
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div id="addEmployeeModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Add New Employee</h3>
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Full Name
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                id="name" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="employee_id">
                                Employee ID
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('employee_id') border-red-500 @enderror"
                                id="employee_id" type="text" name="employee_id" value="{{ old('employee_id') }}" required>
                            @error('employee_id')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nic">
                                NIC Number
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nic') border-red-500 @enderror"
                                id="nic" type="text" name="nic" value="{{ old('nic') }}" required>
                            @error('nic')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email Address
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                id="email" type="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Initial Password
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                                id="password" type="password" name="password" required>
                            @error('password')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Create Employee
                            </button>
                            <button type="button" onclick="document.getElementById('addEmployeeModal').classList.add('hidden')" 
                                class="text-blue-500 hover:text-blue-800">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Admin User</h3>
                    <form action="{{ route('admin.users.update', $employee->id) }}" method="POST" id="editEmployeeForm"  >
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_name">
                                    Full Name
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_name" type="text" name="name" value="{{ old('name', $employee->name) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_employee_id">
                                    Employee ID
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_employee_id" type="text" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_nic">
                                    NIC Number
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_nic" type="text" name="nic" value="{{ old('nic', $employee->nic) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_email">
                                    Email Address
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_email" type="email" name="email" value="{{ old('email', $employee->email) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_phone_number">
                                    Phone Number
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_phone_number" type="text" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_emergency_contact">
                                    Emergency Contact
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_emergency_contact" type="text" name="emergency_contact" value="{{ old('emergency_contact', $employee->emergency_contact) }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_bank_name">
                                    Bank Name
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_bank_name" type="text" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_bank_account_no">
                                    Bank Account Number
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="edit_bank_account_no" type="text" name="bank_account_no" value="{{ old('bank_account_no', $employee->bank_account_no) }}">
                            </div>
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_address">
                                Address
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="edit_address" name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Update Admin User
                            </button>
                            <button type="button" onclick="document.getElementById('editEmployeeModal').classList.add('hidden')" 
                                class="text-blue-500 hover:text-blue-800">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editEmployee(id) {
        window.location.href = "{{ route('admin.employees.edit', ['employee' => ':id']) }}".replace(':id', id);
    }

    function deleteEmployee(id) {
        if (confirm('Are you sure you want to delete this employee?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${id}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
@endsection 