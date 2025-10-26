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
        if (!User::where('email', 'captain@mail.com')->exists()) {
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
        }

        // Create Barangay Secretary
        if (!User::where('email', 'secretary@mail.com')->exists()) {
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

        // Create Tanod 1
        if (!User::where('email', 'tanod1@mail.com')->exists()) {
            User::create([
                'first_name' => 'Pedro',
                'middle_name' => 'Reyes',
                'last_name' => 'Gonzales',
                'suffix' => null,
                'email' => 'tanod1@mail.com',
                'password' => Hash::make('password'),
                'role' => 'tanod',
                'national_id' => 'TANOD-001',
                'date_of_birth' => '1990-03-10',
                'age' => 34,
                'gender' => 'male',
                'civil_status' => 'married',
                'phone' => '09987654321',
                'address' => 'Barangay',
                'street' => 'Response Unit Street',
                'barangay' => 'Barangay',
                'city' => 'City',
                'province' => 'Province',
                'verification_status' => 'approved',
                'verified_at' => now(),
            ]);
        }

        // Create Tanod 2
        if (!User::where('email', 'tanod2@mail.com')->exists()) {
            User::create([
                'first_name' => 'Carlos',
                'middle_name' => 'Villanueva',
                'last_name' => 'Ramos',
                'suffix' => null,
                'email' => 'tanod2@mail.com',
                'password' => Hash::make('password'),
                'role' => 'tanod',
                'national_id' => 'TANOD-002',
                'date_of_birth' => '1988-07-22',
                'age' => 36,
                'gender' => 'male',
                'civil_status' => 'single',
                'phone' => '09987654320',
                'address' => 'Barangay',
                'street' => 'Response Unit Street',
                'barangay' => 'Barangay',
                'city' => 'City',
                'province' => 'Province',
                'verification_status' => 'approved',
                'verified_at' => now(),
            ]);
        }
    }
}
