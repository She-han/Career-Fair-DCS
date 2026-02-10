<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class TestStudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create test student user
        $user = User::create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'is_active' => true,
        ]);

        // Create student profile
        Student::create([
            'user_id' => $user->id,
            'name_with_initials' => 'T.S. Student',
            'sc_number' => 'SC/2023/12345',
            'uni_email' => 'student@test.com',
            'phone' => '0771234567',
            'gpa' => 3.75,
        ]);

        $this->command->info('Test student created!');
        $this->command->info('Email: student@test.com');
        $this->command->info('Password: student123');
    }
}
