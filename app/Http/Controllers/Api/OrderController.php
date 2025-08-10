<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Drink;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Submit a new order
     */
    public function createOrder(CreateOrderRequest $request): JsonResponse
    {
            // Find drink by Id
            $drink = Drink::findOrFail($request->drink_id);
            $unitPrice = $drink->getPriceBySize($request->size);
            $totalPrice = $unitPrice * $request->quantity;

            $order = Order::create([
                'user_id' => auth()->id(),
                'drink_id' => $drink->id,
                'drink_name' => $drink->name,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
                'temperature' => $request->temperature ?? 'cold',
                'order_time' => now(),
            ]);

            return response()->json([
                'message' => 'Order created successfully',
                'data' => new OrderResource($order->load('drink'))
            ], 201);
            
    }

    /**
     * Get all orders
     */
    public function listOrder(): JsonResponse
    {
            $orders = Order::with('drink')->orderBy('order_time', 'desc')->get();
           
            return response()->json([
                'message' => 'Order retrieved successfully',
                'data' => OrderResource::collection($orders)
            ]);
    }

    /**
     * Group orders by drink type 
     */
    public function salesByDrinkType():JsonResponse
    {
            $sales = Order::join('drinks', 'orders.drink_id', '=', 'drinks.id')
                ->select(
                    'drinks.type',
                    DB::raw('SUM(orders.price) as total_sales'),
                    DB::raw('SUM(orders.quantity) as total_quantity'),
                    DB::raw('COUNT(orders.id) as total_orders')
                )
                ->groupBy('drinks.type')
                ->get();


            return response()->json([
                'message' => 'Your sales by drink type retrieved successfully.',
                'data' => $sales->map(function ($item){
                    return [
                        'type' => ucfirst($item->type),
                        'total_sales' => (float) $item->total_sales,
                        'total_quantity' => (int) $item->total_quantity,
                        'total_orders' => (int) $item->total_orders,
                    ];
                }),
            ]);
    }

    /**
     * Group orders by size 
     */
    public function salesBySize(): JsonResponse
    {
       $sales = Order::select(
                'size',
                DB::raw('SUM(price) as total_sales'),
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('COUNT(id) as total_orders')
            )
            ->groupBy('size')
            ->get();

        return response()->json([
            'message' => 'Your sales by size retrieved successfully',
            'data' => $sales->map(function ($item){
                    return [
                        'size' => ucfirst($item->size),
                        'total_sales' => (float) $item->total_sales,
                        'total_quantity' => (int) $item->total_quantity,
                        'total_orders' => (int) $item->total_orders,
                    ];
            }),
        ]);
    }
}
