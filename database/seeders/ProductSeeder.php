<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory(20)->create(); // 20 productos de ejemplo
    }
}
