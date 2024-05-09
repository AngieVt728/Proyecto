<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin =   User::create([
            'first_name' => 'User',
            'last_name' => 'Admin',
            'ci' => '00000001',
            'email' => 'user@admin.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $staff =  User::create([
            'first_name' => 'User',
            'last_name' => 'Staff',
            'ci' => '00000002',
            'email' => 'user@staff.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole('staff');

        User::factory()
            ->count(50)
            ->create()
            ->each(function (User $user) {
                $role = rand(0, 1) === 0 ? 'staff' : 'admin';
                $user->assignRole($role);
            });
    }
}
