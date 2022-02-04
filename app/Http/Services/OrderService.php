<?php
namespace App\Http\Services;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class OrderService {

    /**
     * @var ProductService
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(array $data)
    {
        $data['id'] = Str::orderedUuid();

        return Order::create($data);
    }

    public function findById(string $id)
    {
        return Order::find($id);
    }

    public function process(Order $order)
    {
        if ($order->status == 'failed') {
            return;
        }

        if ($order->total_paid < $order->total) {
            $order->status = 'failed';
            return $order->saveOrFail();
        }

        $order->total_change = $order->total_paid - $order->total;
        $order->status = 'paid';
        $this->reduceStock($order);

        return $order->saveOrFail();
    }

    private function reduceStock(Order $order)
    {
        $product = $order->product;

        $this->productService->reduceStock($product, $order->amount);
    }
}
