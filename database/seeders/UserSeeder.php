<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('adminID'),
        //     'role' => 'admin'
        // ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('adminID'),
            'role' => 'admin'
        ]);
        // User::create([
        //     'name' => 'staff',
        //     'email' => 'staff@gmail.com',
        //     'password' => Hash::make('staffID'),
        //     'role' => 'staff'
        // ]);
        // User::create([
        //     'name' => 'user',
        //     'email' => 'user@gmail.com',
        //     'password' => Hash::make('userID'),
        //     'role' => 'user'
        // ]);
    }
}
