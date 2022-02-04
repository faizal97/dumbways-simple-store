<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use App\Jobs\OrderProcessJob;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function save(OrderRequest $request, OrderService $orderService, ProductService $productService)
    {
        $user = auth()->user();
        $product = $productService->findById($request->input('productId'));
        $order = $orderService->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'status' => 'unpaid',
            'price' => $product->price ?? 0,
            'amount' => $request->input('amount'),
            'total' => ($product->price * $request->input('amount')),
            'total_paid' => $request->input('totalPaid'),
        ]);
        OrderProcessJob::dispatch($order->id);

        return response()->json([
            'status' => 'success',
            'message' => 'order has been placed successfully.',
        ]);
    }
}
