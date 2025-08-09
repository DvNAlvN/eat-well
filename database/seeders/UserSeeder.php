<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => "admin@gmail.com",
            'role' => 'Admin',
            'password' => Hash::make('password123')
        ]);

        User::factory()->create([
            'email' => "eatwell517@gmail.com",
            'password' => Hash::make('password'),
            'role' => 'Customer',
        ]);

        User::factory()->create([
            'email' => "customer2@gmail.com",
            'password' => Hash::make('password'),
            'role' => 'Customer',
        ]);
    }
}
