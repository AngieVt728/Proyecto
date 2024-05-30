<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\RetailOutlet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            RetailOutletSeeder::class,
            SupplierSeeder::class,
            RawMaterialSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            SaleSeeder::class,
            PaymentSeeder::class,
            RevenueSeeder::class,
            EntrySeeder::class,
            OutflowSeeder::class
        ]);
    }
}
