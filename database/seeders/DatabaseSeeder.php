<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin User',
            'username' => 'Admin',
            'billeting_quarter' => 'Main HQ',
            'password' => Hash::make('!Admin123'),
            'division' => 'Main HQ',
            'role' => 'admin',
            'is_deleted' => false,
        ]);
    }
}
