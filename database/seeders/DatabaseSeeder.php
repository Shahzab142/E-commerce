<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@khyberpro.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'employee@khyberpro.com'],
            [
                'name' => 'Employee User',
                'password' => bcrypt('password123'),
                'role' => User::ROLE_EMPLOYEE,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@khyberpro.com'],
            [
                'name' => 'Customer User',
                'password' => bcrypt('password123'),
                'role' => User::ROLE_USER,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );
    }
}
