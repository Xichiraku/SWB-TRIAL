<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua user yang ada (optional)
        User::truncate();

        // Insert user default
        User::create([
            'username' => 'Admin1',
            'password' => 'admin123', // Akan di-hash otomatis
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'Operator1',
            'password' => 'operator123',
            'role' => 'operator'
        ]);

        echo "✅ Users created successfully!\n";
        echo "📋 Login credentials:\n";
        echo "   Admin - Username: Admin1, Password: admin123\n";
        echo "   Operator - Username: Operator1, Password: operator123\n";
    }
}