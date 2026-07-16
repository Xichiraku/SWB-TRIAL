<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'Admin1', 'password' => 'admin123', 'role' => 'admin'],
            ['username' => 'Operator1', 'password' => 'operator123', 'role' => 'operator'],
            ['username' => 'Admin2', 'password' => 'admin456', 'role' => 'admin'],
            ['username' => 'Operator2', 'password' => 'operator456', 'role' => 'operator'],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['username' => $user['username']],
                [
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Users seeded.');
    }
}