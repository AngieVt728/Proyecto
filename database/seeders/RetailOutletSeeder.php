<?php

namespace Database\Seeders;

use App\Models\RetailOutlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetailOutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RetailOutlet::factory(15)->create();
    }
}
