<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'developer2',
            'email' => 'developer2@example.com',
            'password' => Hash::make('Test@Password123#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
