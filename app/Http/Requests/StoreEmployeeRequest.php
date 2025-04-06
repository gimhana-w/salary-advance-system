<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'password' => ['required', 'string', 'min:8'],
            'employee_id' => ['required', 'string', 'max:50', 'unique:employees'],
            'nic' => ['required', 'string', 'max:20', 'unique:employees'],
            'department' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:100'],
            'base_salary' => ['required', 'numeric', 'min:0'],
            'phone_number' => ['required', 'string', 'max:20'],
            'join_date' => ['required', 'date'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'bank_account_no' => ['nullable', 'string', 'max:50'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'is_admin' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The employee name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'phone_number.required' => 'The phone number is required.',
            'employee_id.required' => 'The employee ID is required.',
            'employee_id.unique' => 'This employee ID is already in use.',
            'department.required' => 'The department is required.',
            'base_salary.required' => 'The base salary is required.',
            'base_salary.numeric' => 'The base salary must be a number.',
            'base_salary.min' => 'The base salary cannot be negative.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
} 