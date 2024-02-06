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
        // Seed a sample user with a generated_id
        DB::table('users')->insert([
            'name' => 'Sample User',
            'email' => 'sample@example.com',
            'password' => Hash::make('password'),
            'generated_id' => Str::uuid(), // Generate and insert a unique generated_id
        ]);

        // Add more users as needed
    }
}

