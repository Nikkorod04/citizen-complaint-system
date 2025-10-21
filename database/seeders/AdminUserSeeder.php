<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Barangay Captain
        User::create([
            'first_name' => 'Juan',
            'middle_name' => 'Santos',
            'last_name' => 'Dela Cruz',
            'suffix' => null,
            'email' => 'captain@mail.com',
            'password' => Hash::make('password'),
            'role' => 'captain',
            'national_id' => 'CAPTAIN-001',
            'date_of_birth' => '1975-01-15',
            'age' => 49,
            'gender' => 'male',
            'civil_status' => 'married',
            'phone' => '09123456789',
            'address' => 'Barangay Hall',
            'street' => 'Main Street',
            'barangay' => 'Barangay',
            'city' => 'City',
            'province' => 'Province',
            'verification_status' => 'approved',
            'verified_at' => now(),
        ]);

        // Create Barangay Secretary
        User::create([
            'first_name' => 'Maria',
            'middle_name' => 'Garcia',
            'last_name' => 'Santos',
            'suffix' => null,
            'email' => 'secretary@mail.com',
            'password' => Hash::make('password'),
            'role' => 'secretary',
            'national_id' => 'SECRETARY-001',
            'date_of_birth' => '1980-05-20',
            'age' => 44,
            'gender' => 'female',
            'civil_status' => 'single',
            'phone' => '09123456788',
            'address' => 'Barangay Hall',
            'street' => 'Main Street',
            'barangay' => 'Barangay',
            'city' => 'City',
            'province' => 'Province',
            'verification_status' => 'approved',
            'verified_at' => now(),
        ]);
    }
}
