<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryAdvanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required', 
                'numeric', 
                'min:1000', 
                'max:' . config('app.max_advance_amount', 50000)
            ],
            'reason' => ['required', 'string', 'min:10', 'max:500'],
            'needed_by_date' => [
                'required', 
                'date', 
                'after:today', 
                'before:+1 month'
            ],
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
            'amount.required' => 'The advance amount is required.',
            'amount.numeric' => 'The advance amount must be a number.',
            'amount.min' => 'The advance amount must be at least 1,000.',
            'amount.max' => 'The advance amount cannot exceed ' . config('app.max_advance_amount', 50000) . '.',
            'reason.required' => 'Please provide a reason for your advance request.',
            'reason.min' => 'The reason must be at least 10 characters.',
            'reason.max' => 'The reason cannot exceed 500 characters.',
            'needed_by_date.required' => 'Please specify when you need the advance by.',
            'needed_by_date.date' => 'Please enter a valid date.',
            'needed_by_date.after' => 'The needed by date must be after today.',
            'needed_by_date.before' => 'The needed by date must be within one month from today.',
        ];
    }
} 