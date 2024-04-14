<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'email' => 'admin@example.com',
                'created_at' => '2024-04-10 16:05:21',
                'updated_at' => '2024-04-10 16:05:23',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'username' => 'staff',
                'password' => Hash::make('staff'),
                'role' => 'staff',
                'email' => 'staff@email.com',
                'created_at' => '2024-04-10 08:09:41',
                'updated_at' => '2024-04-10 08:09:41',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'username' => 'audit',
                'password' => Hash::make('audit'),
                'role' => 'auditor',
                'email' => 'audit@email.com',
                'created_at' => '2024-04-13 22:21:01',
                'updated_at' => '2024-04-13 22:21:04',
                'deleted_at' => null
            ]
        ]);
    }
}
