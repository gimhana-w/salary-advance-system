@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Employee Management</h2>
        <a href="{{ route('admin.employees.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Employee
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Employee ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">NIC</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($employees as $employee)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">
                        {{ $employee->employee_id }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $employee->name }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $employee->email }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $employee->nic }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($employee->department === 'Pending')
                            <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">
                                Profile Incomplete
                            </span>
                        @else
                            <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">
                                Profile Complete
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2">
                                Edit
                            </a>
                            <form action="{{ route('admin.employees.delete', $employee) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded" onclick="return confirm('Are you sure you want to delete this employee?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
@endsection 