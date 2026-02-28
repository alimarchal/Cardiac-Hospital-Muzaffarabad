<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Administrator user
        $admin = User::updateOrCreate(['id' => 1], [
            'name' => 'Administrator',
            'email' => 'admin@cardiac.test',
            'password' => Hash::make('password'),
            'department_id' => null,
            'status' => true,
            'profile_photo_path' => null,
        ]);

        $admin->syncRoles(['Super-Admin']);

        // Create Administrator user
        $administrator = User::updateOrCreate(['id' => 3], [
            'name' => 'Administrator User',
            'email' => 'administrator@cardiac.test',
            'password' => Hash::make('password'),
            'department_id' => null,
            'status' => true,
            'profile_photo_path' => null,
        ]);

        $administrator->syncRoles(['Administrator']);

        // Create Front Desk user
        $frontDesk = User::updateOrCreate(['id' => 2], [
            'name' => 'Front Desk User',
            'email' => 'receptionist@cardiac.test',
            'password' => Hash::make('password'),
            'department_id' => null,
            'status' => true,
            'profile_photo_path' => null,
        ]);

        $frontDesk->syncRoles(['Front Desk/Receptionist']);
    }
}
