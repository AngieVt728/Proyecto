<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'ci' => fake()->numberBetween(100000, 99999999),
            'contact' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'username' => 'sadmin',
            'email' => 'super.admin@imbae.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => fake()->imageUrl(),
            'remember_token' => Str::random(10)
        ])->assignRole('super-admin');

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'ci' => fake()->numberBetween(100000, 99999999),
            'contact' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'username' => 'admin',
            'email' => 'admin@imbae.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => fake()->imageUrl(),
            'remember_token' => Str::random(10)
        ])->assignRole('admin');

        User::create([
            'first_name' => 'Manager',
            'last_name' => 'Manager',
            'ci' => fake()->numberBetween(100000, 99999999),
            'contact' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'username' => 'manager',
            'email' => 'manager@imbae.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => fake()->imageUrl(),
            'remember_token' => Str::random(10)
        ])->assignRole('manager');

        User::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'ci' => fake()->numberBetween(100000, 99999999),
            'contact' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'username' => 'user',
            'email' => 'user@imbae.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => fake()->imageUrl(),
            'remember_token' => Str::random(10)
        ])->assignRole('user');

        User::factory()
            ->count(25)
            ->create()
            ->each(function (User $user) {
                $role = rand(0, 1) === 0 ? 'manager' : 'user';
                $user->assignRole($role);
            });
    }
}
