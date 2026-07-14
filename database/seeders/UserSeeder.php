<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // SUPER ADMIN
        // =========================
        User::create([
            'name'      => 'Super Admin',
            'email'     => 'superadmin@gmail.com',
            'password'  => Hash::make('superadmin123'),
            'role'      => 'superadmin',
            'is_active' => true,
        ]);

        // =========================
        // ADMIN 1
        // =========================
        User::create([
            'name'      => 'Admin 1',
            'email'     => 'admin1@gmail.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // =========================
        // ADMIN 2
        // =========================
        User::create([
            'name'      => 'Admin 2',
            'email'     => 'admin2@gmail.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // =========================
        // ADMIN 3
        // =========================
        User::create([
            'name'      => 'Admin 3',
            'email'     => 'admin3@gmail.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // =========================
        // ADMIN 4
        // =========================
        User::create([
            'name'      => 'Admin 4',
            'email'     => 'admin4@gmail.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
    }
}