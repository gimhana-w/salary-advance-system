<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Employee::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'employee_id' => 'EMP001',
            'nic' => '123456789V',
            'department' => 'Administration',
            'position' => 'System Administrator',
            'base_salary' => 75000.00,
            'phone_number' => '0771234567',
            
            'emergency_contact' => '0712345678',
            'address' => 'Colombo, Sri Lanka',
            'bank_account_no' => '1234567890',
            'bank_name' => 'Commercial Bank',
            'is_admin' => true,
            'is_active' => true,
        ]);

        // Create some departments with managers
        $departments = [
            [
                'name' => 'HR Manager',
                'email' => 'hr@example.com',
                'department' => 'Human Resources',
                'position' => 'HR Manager',
                'base_salary' => 65000.00,
            ],
            [
                'name' => 'Finance Manager',
                'email' => 'finance@example.com',
                'department' => 'Finance',
                'position' => 'Finance Manager',
                'base_salary' => 68000.00,
            ],
            [
                'name' => 'IT Manager',
                'email' => 'it@example.com',
                'department' => 'Information Technology',
                'position' => 'IT Manager',
                'base_salary' => 70000.00,
            ]
        ];

        foreach ($departments as $index => $manager) {
            Employee::create([
                'name' => $manager['name'],
                'email' => $manager['email'],
                'password' => Hash::make('password'),
                'employee_id' => 'EMP00' . ($index + 2),
                'nic' => '98765432' . ($index + 1) . 'V',
                'department' => $manager['department'],
                'position' => $manager['position'],
                'base_salary' => $manager['base_salary'],
                'phone_number' => '077' . rand(1000000, 9999999),
                'emergency_contact' => '071' . rand(1000000, 9999999),
                'address' => 'Sri Lanka',
                'bank_account_no' => rand(1000000000, 9999999999),
                'bank_name' => 'Commercial Bank',
                'is_admin' => true,
                'is_active' => true,
            ]);
        }
    }
} 