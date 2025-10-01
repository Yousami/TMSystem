<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // ایجاد کاربر ادمین اگر وجود ندارد
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        // اختصاص نقش ادمین
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // ایجاد کاربران نمونه دیگر
        $users = [
            [
                'name' => 'Agent User',
                'email' => 'agent@example.com',
                'role' => 'agent'
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => 'user'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            
            $role = Role::where('name', $userData['role'])->first();
            if ($role && !$user->hasRole($userData['role'])) {
                $user->assignRole($userData['role']);
            }
        }
    }
}
