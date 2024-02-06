<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Seed a sample user
        DB::table('users')->insert([
            'name' => 'Sample User',
            'email' => 'sample@example.com',
            'password' => Hash::make('password'),

        ]);

        // Add more users as needed
    }
}
