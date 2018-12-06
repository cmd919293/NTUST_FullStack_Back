<?php

namespace App\Http\Controllers\api;

use App\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $Uid = auth('api')->user()->getAuthIdentifier();
        $orders = Order::query()
            ->where('UserId', $Uid)
            ->join('OrderItem', 'Order.id', '=', 'OrderId')
            ->join('MonsterName', 'MonsterName.id', '=', 'OrderItem.ProductId')
            ->select('Address', 'Shipment', 'OrderId', 'ProductId', 'Count', 'Price', 'Order.created_at', 'NAME', 'Phone')
            ->orderBy('OrderId', 'desc')
            ->orderBy('ProductId')
            ->get();
        $data = [];
        foreach ($orders as $item) {
            $data[$item['OrderId']]['Address'] = $item['Address'];
            $data[$item['OrderId']]['Shipment'] = boolval($item['Shipment']);
            if (array_key_exists('Total', $data[$item['OrderId']])) {
                $data[$item['OrderId']]['Total'] += $item['Count'] * $item['Price'];
            } else {
                $data[$item['OrderId']]['Total'] = $item['Count'] * $item['Price'];
            }
            $data[$item['OrderId']]['Phone'] = $item['Phone'];
            $data[$item['OrderId']]['createdAt'] = $item['created_at']->format('Y-m-d H:i:s');
            $data[$item['OrderId']]['items'][] = [
                'ProductId' => $item['ProductId'],
                'Count' => $item['Count'],
                'Price' => $item['Price'],
                'NAME' => $item['NAME'],
                'Icon' => $this->GetIcon($item['ProductId'])
            ];
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'order' => array_values($data)
        ], 200);
    }

    public function getAll()
    {
        $orders = Order::query()
            ->join('OrderItem', 'Order.id', '=', 'OrderId')
            ->join('MonsterName', 'MonsterName.id', '=', 'OrderItem.ProductId')
            ->select('Address', 'Shipment', 'OrderId', 'ProductId', 'Count', 'Price', 'Order.created_at', 'NAME', 'Phone')
            ->orderBy('OrderId')
            ->orderBy('ProductId')
            ->get();
        $data = [];
        foreach ($orders as $item) {
            $data[$item['OrderId']]['Address'] = $item['Address'];
            $data[$item['OrderId']]['Shipment'] = boolval($item['Shipment']);
            if (array_key_exists('Total', $data[$item['OrderId']])) {
                $data[$item['OrderId']]['Total'] += $item['Count'] * $item['Price'];
            } else {
                $data[$item['OrderId']]['Total'] = $item['Count'] * $item['Price'];
            }
            $data[$item['OrderId']]['Phone'] = $item['Phone'];
            $data[$item['OrderId']]['createdAt'] = $item['created_at']->format('Y-m-d H:i:s');
            $data[$item['OrderId']]['items'][] = [
                'ProductId' => $item['ProductId'],
                'Count' => $item['Count'],
                'Price' => $item['Price'],
                'NAME' => $item['NAME'],
                'Icon' => $this->GetIcon($item['ProductId'])
            ];
        }
        return view('listOrder', ['orders' => $data]);
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

    private function GetIcon($monId)
    {
        return json_decode(json_encode(app(ImageController::class)->ToBase64($monId)), true)['original'];
    }
}
