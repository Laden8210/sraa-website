<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Participant::insert([
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'participant_role' => 'Student',
                'division' => 'Science',
                'school' => 'Springfield High',
                'event' => 'Math Olympiad',
                'password' => Hash::make('password123'),
                'is_deleted' => false,
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'participant_role' => 'Teacher',
                'division' => 'Mathematics',
                'school' => 'Riverside Academy',
                'event' => 'Science Fair',
                'password' => Hash::make('securepass'),
                'is_deleted' => false,
            ]
        ]);
    }
}
