<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First admin user
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@careerfair.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Second admin user - DCS department
        \App\Models\User::firstOrCreate(
            ['email' => 'aruna@dcs.ruh.ac.lk'],
            [
                'name' => 'Aruna Lorensuhewa',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Admin 1 - Email: admin@careerfair.com | Password: admin123');
        $this->command->info('Admin 2 - Email: aruna@dcs.ruh.ac.lk | Password: admin123');
    }
}
