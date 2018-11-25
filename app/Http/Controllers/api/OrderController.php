<?php

namespace App\Http\Controllers\api;

use App\Order;
use App\OrderItem;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        if (auth('api')->user()->getAuthIdentifier() === 0) {
            Order::query()->where('id', $id)->update(['Shipment'], true);
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
