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
        $Uid = auth('api')->user()->getAuthIdentifier();
        $order = Order::query()->where('UserId', $Uid)
            ->orderBy('id')
            ->get();
        $orders = Order::query()
            ->join('OrderItem', 'Order.id', '=', 'OrderId')
            ->select('Address', 'Shipment', 'OrderId', 'ProductId', 'Count', 'Price', 'order.created_at')
            ->orderBy('OrderId')
            ->get();
        $data = [];
        foreach ($orders as $item) {
            $data[$item['OrderId']]['Address'] = $item['Address'];
            $data[$item['OrderId']]['Shipment'] = boolval($item['Shipment']);
            $data[$item['OrderId']]['created_at'] = $item['created_at']->format('c');
            $data[$item['OrderId']]['items'][] = [
                'ProductId' => $item['ProductId'],
                'Count' => $item['Count'],
                'Price' => $item['Price']
            ];
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'order' => array_values($data)
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
        Order::query()->where('id', $id)->update(['Shipment' => true]);
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }
}
