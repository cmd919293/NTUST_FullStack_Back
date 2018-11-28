<?php

namespace App\Http\Controllers\api;

use App\Order;
use App\OrderItem;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orderItems = OrderItem::query()
            ->where('UserID', auth('api')->user()->getAuthIdentifier())
            ->orderBy('OrderID')
            ->orderBy('ProductID')
            ->orderBy('Price')
            ->orderBy('Count')
            ->get();
        $data = [];
        foreach ($orderItems as $item) {
            $data[$item['OrderID']][] = [
                'ProductID' => $item['ProductID'],
                'Count' => $item['Count'],
                'Price' => $item['Price']
            ];
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'order' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        if (auth('api')->user()['permission'] === 0) {
            Order::query()->where('id', $id)->update(['Shipment' => true]);
            return response()->json(
                [
                    'status' => true,
                    'message' => []
                ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => [
                'permission' => 'permission error'
            ]
        ], 403);
    }
}
