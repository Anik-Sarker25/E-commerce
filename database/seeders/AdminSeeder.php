<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'show_password' => '12345678',
                'role' => Constant::USER_TYPE['admin'],
                'status' => Constant::USER_STATUS['active'],
                'created_at' => now()
            ]
        );
    }
}
