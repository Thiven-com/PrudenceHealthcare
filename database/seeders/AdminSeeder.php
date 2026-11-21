<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@prudence.com',
            'mobile' => '9999999999',
            'password' => Hash::make('Admin@123456'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);
    }
}