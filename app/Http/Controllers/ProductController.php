<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function getAll(ProductService $productService)
    {
        return ProductResource::collection($productService->getAll());
    }

    public function get(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request, ProductService $productService)
    {
        $product = $productService->create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'successfully created product',
        ], 201);
    }

    public function update(Product $product, ProductRequest $request, ProductService $productService)
    {
        $productService->update($product, [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'successfully updated product',
        ]);
    }

    public function destroy(Product $product, ProductService $productService)
    {
        $productService->delete($product);

        return response()->json([
            'status' => 'success',
            'message' => 'successfully deleted product',
        ]);
    }
}
