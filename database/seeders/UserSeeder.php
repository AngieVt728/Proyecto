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
            'first_name' => 'Admin',
            'last_name' => 'User',
            'ci' => '00000001',
            'email' => 'admin@user.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $staff =  User::create([
            'first_name' => 'Staff',
            'last_name' => 'User',
            'ci' => '00000002',
            'email' => 'staff@user.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole('staff');

        User::factory()
            ->count(25)
            ->create()
            ->each(function (User $user) {
                $role = rand(0, 1) === 0 ? 'staff' : 'admin';
                $user->assignRole($role);
            });
    }
}
