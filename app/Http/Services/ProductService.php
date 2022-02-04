<?php
namespace App\Http\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class ProductService {

    public function getAll()
    {
        return Product::all();
    }

    public function create(array $data): Product
    {
        $data['id'] = Str::orderedUuid();

        return Product::create($data);
    }

    public function update(Product $product, array $data): void
    {
        $product->name = $data['name'] ?? $product->name;
        $product->price = $data['price'] ?? $product->price;
        $product->stock = $data['stock'] ?? $product->stock;
        $product->saveOrFail();
    }

    public function delete(Product $product)
    {
        $product->delete();
    }

    public function findById(string $id)
    {
        return Product::find($id);
    }

    public function reduceStock(Product $product, $amount)
    {
        $product->stock -= $amount;
        $product->saveOrFail();
    }
}
