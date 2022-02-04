<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->create([
            'id' => Str::orderedUuid(),
            'name' => "Kopi Bubuk",
            "price" => 5000,
            "stock" => 20,
        ]);
        Product::factory()->create([
            'id' => Str::orderedUuid(),
            'name' => "Susu UHT",
            "price" => 15000,
            "stock" => 20,
        ]);
    }
}
