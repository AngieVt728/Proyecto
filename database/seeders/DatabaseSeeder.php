<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\RetailOutlet;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class, UserSeeder::class]);

        RetailOutlet::factory(15)->create();
        Product::factory(20)->create();
        Supplier::factory(10)->create();
        RawMaterial::factory(10)->create();
    }
}
