<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'division' => 'IT',
                'billeting_quarter' => 'HQ',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_deleted' => false,
            ],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'division' => 'HR',
                'billeting_quarter' => 'B1',
                'password' => Hash::make('securepass'),
                'role' => 'user',
                'is_deleted' => false,
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'division' => 'Finance',
                'billeting_quarter' => 'B2',
                'password' => Hash::make('mypassword'),
                'role' => 'user',
                'is_deleted' => false,
            ]
        ]);
    }
}
