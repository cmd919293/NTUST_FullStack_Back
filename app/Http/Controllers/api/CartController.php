<?php

namespace App\Http\Controllers\api;

use App\Cart;
use App\Coupon;
use App\MonsterAttributes;
use App\Monsters;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth('api')->user()->getAuthIdentifier();
        $result = [];
        $carts = Cart::query()
            ->join('MonsterName', 'ProductId', '=', 'MonsterName.id')
            ->join('Monsters', 'ProductId', '=', 'Monsters.id')
            ->select('ProductId', 'Count', DB::raw('CEIL(price * discount / 100) as Price'), 'MonsterName.*')
            ->where('UserId', $userId)
            ->get();
        foreach ($carts as $i) {
            $attr = MonsterAttributes::query()->where('MonsterId', $i['ProductId'])
                ->join('AttributeName', 'AttributeName.id', '=', 'MonsterAttributes.AttributeID')
                ->get();
            $data = [
                'ProductId' => $i['ProductId'],
                'Count' => $i['Count'],
                'Price' => $i['Price'],
                'NAME' => $i['NAME'],
                'NAME_EN' => $i['NAME_EN'],
                'NAME_JP' => $i['NAME_JP'],
                'attributes' => [],
                'Icon' => json_decode(json_encode(app(ImageController::class)->ToBase64($i['id'])), true)['original']
            ];
            foreach ($attr as $j) {
                $attrLang = [];
                foreach ($j->getAttributes() as $k => $v) {
                    if (strpos(strtolower($k), 'name') === 0) {
                        $attrLang[$k] = $v;
                    }
                }
                $attrLang['value'] = $j['id'];
                $attrLang['Color'] = $j['Color'];
                array_push($data['attributes'], $attrLang);
            }
            array_push($result, $data);
        }
        return response([
            'status' => true,
            'message' => [],
            'cart' => $result
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Address' => 'required|string',
            'Phone' => ['required', 'regex:/09\d{8}/'],
            'Coupons' => 'required|array'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $Uid = auth('api')->user()->getAuthIdentifier();
        $cart = Cart::query()
            ->where('UserId', $Uid)
            ->select(['id', 'UserId', 'ProductId', 'Count'])
            ->orderBy('ProductId');
        if ($cart->get()->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => [
                    'cart' => 'Cart is Empty'
                ]
            ], 200);
        }
        $order = Order::query()->create([
            'UserId' => $Uid,
            'Phone' => $request['Phone'],
            'Address' => $request['Address'],
        ]);
        $id = $order['id'];
        foreach ($cart->get() as $item) {
            $price = 0;
            $product = Monsters::query()
                ->where('id', $item['ProductId'])
                ->select(DB::raw('CEIL(`price` * `discount` / 100) as discounted'))
                ->get();
            if ($product->isNotEmpty()) {
                $price = $product[0]['discounted'];
            }
            OrderItem::query()
                ->create([
                    'OrderId' => $id,
                    'ProductId' => $item['ProductId'],
                    'Count' => $item['Count'],
                    'Price' => $price
                ]);
        }
        $cart->delete();
        foreach($request['Coupons'] as $CouponId) {
            Coupon::query()
                ->where('id', '=', $CouponId)
                ->where('UserId', '=', $Uid)
                ->where('Used','=',false)
                ->whereDate('expired_at', '>=', $order['created_at'])
                ->update([
                    'OrderId' => $id,
                    'Used' => true
                ]);
        }
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart' => 'array'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        if (!$request->has('cart')) {
            return response()->json([
                'status' => false,
                'message' => [
                    'cart' => ['The cart field is required.']
                ]
            ], 400);
        }
        $cart = $request['cart'];
        if (count($cart) == 0) {
            Cart::query()->where('UserID', auth('api')->user()->getAuthIdentifier())->delete();
            return response()->json([
                'status' => true,
                'message' => [
                    'cart' => 'Clear'
                ]
            ], 200);
        }
        if (array_keys($cart) !== range(0, count($cart) - 1)) {
            return response()->json([
                'status' => false,
                'message' => [
                    'cart' => 'Not a sequential array'
                ]
            ], 400);
        }
        $keys = ["ProductId", "Count"];
        foreach ($cart as $i) {
            if (array_keys($i) !== $keys) {
                return response()->json([
                    'status' => false,
                    'message' => [
                        'cart' => 'key error'
                    ]
                ], 400);
            } else if (!(is_int($i['ProductId']) && is_int($i['Count']))) {
                return response()->json([
                    'status' => false,
                    'message' => [
                        'cart' => 'ProductId and Count must be Numeric'
                    ]
                ], 400);
            }
        }
        $query = Cart::query()->where('UserID', auth('api')->user()->getAuthIdentifier())
            ->select(['id', 'UserID', 'ProductID', 'Count']);
        $query->delete();
        foreach ($cart as $i) {
            Cart::query()->create([
                'UserId' => auth('api')->user()->getAuthIdentifier(),
                'ProductId' => $i['ProductId'],
                'Count' => $i['Count'],
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }

}
