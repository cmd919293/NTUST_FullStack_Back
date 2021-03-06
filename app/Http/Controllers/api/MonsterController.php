<?php

namespace App\Http\Controllers\api;

use App\AttributeName;
use App\MonsterName;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\MonsterAttributes;
use App\Monsters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MonsterController extends Controller
{
    /**
     * @param string $str
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function initQuery($str)
    {
        $arr = explode(',', str_replace(' ', '', strtolower($str)));
        $orderList = [];
        $filterList = [];
        $filterPriceRange = [];
        $filterPrice = false;
        $discounted = DB::raw('Monsters.price * Monsters.discount / 100');
        foreach ($arr as $v) {
            if (intval($v) == 0) {
                $orderList[] = trim($v);
            } else {
                $filterList[] = intval($v);
            }
        }
        $preQuery = MonsterAttributes::query();
        if (count($filterList) != 0) $preQuery = $preQuery->whereIn('AttributeId', $filterList);
        $preQuery = $preQuery->select('MonsterId')->distinct();
        $monQuery = Monsters::query()
            ->leftJoinSub($preQuery, 'MonsterAttributes',
                'Monsters.id', '=', 'MonsterAttributes.MonsterId');
        foreach ($orderList as $v) {
            if ($v == 'newest') {
                $monQuery = $monQuery->orderBy('Monsters.created_at', 'DESC');
            } else if ($v == 'cheapest') {
                $monQuery = $monQuery->orderBy($discounted, 'ASC');
            } else if ($v == 'hottest') {
                $monQuery = $monQuery->orderBy('Monsters.sold', 'DESC');
            } else if (starts_with($v, 'price')) {
                $filterPriceRange = explode('-', substr($v, 6));
                $filterPrice = sort($filterPriceRange, SORT_NUMERIC) && (count($filterPriceRange) == 2);
            } else if (starts_with($v, 'id')) {
                $id = intval(substr($v, 3));
                $monQuery = $monQuery->where(DB::raw('`monsters`.`id`'), $id);
            }
        }
        if ($filterPrice) {
            $monQuery = $monQuery->whereBetween($discounted, $filterPriceRange);
        }
        if (count($filterList) != 0) {
            $newRule = MonsterAttributes::query()
                ->whereIn('AttributeId', $filterList);
            $monQuery = $monQuery
                ->joinSub($newRule, 'MA2',
                    'Monsters.id', '=', 'MA2.MonsterId'
                );
        }
        return $monQuery->distinct();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $mon
     * @return array
     */
    public function makeResponse($mon)
    {
        $data = [];
        foreach ($mon as $i) {
            $attr = MonsterAttributes::query()->where('MonsterId', $i['id'])
                ->join('AttributeName', 'AttributeName.id', '=', 'MonsterAttributes.AttributeID')
                ->get();
            $result = [
                'ATTACK' => $i['ATTACK'],
                'DEFENSE' => $i['DEFENSE'],
                'HP' => $i['HP'],
                'NAME' => $i['NAME'],
                'NAME_EN' => $i['NAME_EN'],
                'NAME_JP' => $i['NAME_JP'],
                'SPEED' => $i['SPEED'],
                'SP_ATTACK' => $i['SP_ATTACK'],
                'SP_DEFENSE' => $i['SP_DEFENSE'],
                'createdAt' => $i['created_at']->format('c'),
                'description' => $i['description'],
                'discount' => $i['discount'],
                'id' => $i['id'],
                'imgNum' => $i['imgNum'],
                'price' => $i['price'],
                'sold' => $i['sold'],
                'finalPrice' => ceil($i['price'] * $i['discount'] / 100),
                'attributes' => [],
                'Icon' => $this->GetIcon($i['id'])
            ];
            foreach ($attr as $j) {
                $attrLang = [];
                foreach ($j->getAttributes() as $k => $v) {
                    if (strpos(strtolower($k), 'name') === 0) {
                        $attrLang[$k] = $v;
                    }
                }
                $attrLang['value'] = $j['id'];
                array_push($result['attributes'], $attrLang);
            }
            array_push($data, $result);
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Monsters::INS_RULE);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $images = $request->file('image');
        /** @var UploadedFile $image */
        foreach ($images as $image) {
            $imgValidate = Validator::make(['image' => $image], ['image' => 'required|image']);
            if ($imgValidate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $imgValidate->getMessageBag()
                ], 400);
            }
        }

        if (array_keys($request['attributes']) !== range(0, count($request['attributes']) - 1)) {
            return response()->json([
                'status' => false,
                'message' => [
                    'attributes' => 'attributes error'
                ]
            ], 400);
        }

        $newRow = Monsters::query()->create([
            'imgNum' => count($images),
            'HP' => $request['HP'],
            'ATTACK' => $request['ATTACK'],
            'DEFENSE' => $request['DEFENSE'],
            'SP_ATTACK' => $request['SP_ATTACK'],
            'SP_DEFENSE' => $request['SP_DEFENSE'],
            'SPEED' => $request['SPEED'],
            'sold' => $request['sold'],
            'price' => $request['price'],
            'description' => $request['description'],
        ]);
        $monId = $newRow['id'];
        //Insert New Monster
        MonsterName::query()->create([
            'id' => $monId,
            'NAME' => $request['NAME'],
            'NAME_EN' => $request['NAME_EN'],
            'NAME_JP' => $request['NAME_JP']
        ]);
        $arr = AttributeName::query()->whereIn('id', $request['attributes'])
            ->select('id')->get()->toArray();

        //Insert MonsterAttribute
        foreach ($arr as $v) {
            MonsterAttributes::query()->create([
                'MonsterId' => $monId,
                'AttributeId' => $v['id']
            ]);
        }

        //Store Image
        foreach ($images as $k => $image) {
            $image->storeAs("img/$monId", "$k.jpg");
        }
        return response()->json([
            'status' => true,
            'message' => [
                'Data' => 'Insert Success'
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), Monsters::UPDATE_RULE);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $monId = $request['id'];
        $checkName = MonsterName::query()->orWhere([
            'NAME' => $request['NAME'],
            'NAME_JP' => $request['NAME_JP'],
            'NAME_EN' => $request['NAME_EN'],
        ])->get();
        if ($checkName->isNotEmpty()) {
            if ($checkName->count() > 1 || $checkName[0]['id'] != $monId) {
                $msg = [];
                if (Monsters::query()->orWhere(['NAME' => $request['NAME'], 'id' => $monId])->count() > 1) {
                    $msg['NAME'] = 'This NAME is exists.';
                }
                if (Monsters::query()->orWhere(['NAME_JP' => $request['NAME_JP'], 'id' => $monId])->count() > 1) {
                    $msg['NAME_JP'] = 'This NAME_JP is exists.';
                }
                if (Monsters::query()->orWhere(['NAME_EN' => $request['NAME_EN'], 'id' => $monId])->count() > 1) {
                    $msg['NAME_EN'] = 'This NAME_EN is exists.';
                }
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 400);
            }
        }

        $images = $request->file('image');
        /** @var UploadedFile $image */
        if ($images) {
            foreach ($images as $image) {
                $imgValidate = Validator::make(['image' => $image], ['image' => 'required|image']);
                if ($imgValidate->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $imgValidate->getMessageBag()
                    ], 400);
                }
            }
        }

        if (array_keys($request['attributes']) !== range(0, count($request['attributes']) - 1)) {
            return response()->json([
                'status' => false,
                'message' => [
                    'attributes' => 'attributes error'
                ]
            ], 400);
        }

        //Update Monster
        MonsterName::query()->where(['id' => $monId])
            ->update([
                'NAME' => $request['NAME'],
                'NAME_EN' => $request['NAME_EN'],
                'NAME_JP' => $request['NAME_JP']
            ]);
        $oriAttr = MonsterAttributes::query()->where(['MonsterId' => $monId])
            ->select('AttributeId')
            ->get()->toArray();
        $oriAttr = array_column($oriAttr, 'AttributeId');
        $newAttr = array_unique($request['attributes']);
        $delAttr = array_diff($oriAttr, $newAttr);
        $addAttr = array_diff($newAttr, $oriAttr);
        foreach ($delAttr as $i) {
            MonsterAttributes::query()->where(['MonsterId' => $monId, 'AttributeId' => $i])->delete();
        }
        foreach ($addAttr as $i) {
            MonsterAttributes::query()->create(['MonsterId' => $monId, 'AttributeId' => $i]);
        }

        $mon = Monsters::query()->where(['id' => $monId]);
        $imgNum = $mon->get()[0]['imgNum'];
        if ($request->has('fileControl')) {
            $imgNum = $this->UpdateImage($request['fileControl'], $monId, $imgNum);
        }
        //Store Image
        if ($images) {
            foreach ($images as $k => $image) {
                if ($image->storeAs("img/$monId", "$imgNum.jpg")) {
                    $imgNum++;
                }
            }
        }
        $mon->update([
            'imgNum' => $imgNum,
            'HP' => $request['HP'],
            'ATTACK' => $request['ATTACK'],
            'DEFENSE' => $request['DEFENSE'],
            'SP_ATTACK' => $request['SP_ATTACK'],
            'SP_DEFENSE' => $request['SP_DEFENSE'],
            'SPEED' => $request['SPEED'],
            'price' => $request['price'],
            'discount' => $request['discount'],
            'description' => $request['description'],
        ]);
        return response()->json([
            'status' => true,
            'message' => [
                'Data' => 'Update Success'
            ]
        ]);
    }

    /**
     * @param string $fsStr
     * @return int
     */
    public function amount($fsStr = '*')
    {
        return $this->initQuery($fsStr)->count();
    }

    /**
     * @param string $fsStr
     * @param int $startId
     * @param int $endId
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($fsStr = '*', $startId = 0, $endId = 0)
    {
        $startId = intval($startId);
        $endId = intval($endId);
        if ($startId > $endId || $startId < 0 || $endId < 0) {
            return response(null, 404);
        }
        $mon = $this->initQuery($fsStr)->skip($startId)
            ->take($endId - $startId + 1)
            ->join('MonsterName', 'MonsterName.id', '=', 'monsters.id')
            ->select('MonsterName.*', 'Monsters.*')
            ->get();
        return $this->makeResponse($mon);
    }

    public function search($name)
    {
        $raw = DB::raw("search_monster(\"$name\", `NAME`)");
        $mon = MonsterName::query()->where($raw, '>', 0)
            ->orderBy($raw, 'desc')
            ->join('Monsters', 'MonsterName.id', '=', 'Monsters.id')
            ->get();
        return $this->makeResponse($mon);
    }

    public function destroy($id)
    {
        Monsters::query()->where(['id' => $id])->delete();
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }

    private function GetIcon($monId)
    {
        return json_decode(json_encode(app(ImageController::class)->ToBase64($monId)), true)['original'];
    }

    private function UpdateImageParser($str, $imgNum)
    {
        $charArray = array_map(function ($i) use ($str) {
            return mb_substr($str, $i, 1);
        }, range(0, mb_strlen($str)));
        $temp = array_fill(0, $imgNum, 'o');
        $imgId = 0;
        $action = 'o';
        foreach ($charArray as $ch) {
            $num = intval($ch);
            if ($num != 0 || $ch == '0') {
                $imgId = $imgId * 10 + $num;
            } else {
                if ($imgId < $imgNum && $action != 'o') {
                    $temp[$imgId] = $action;
                }
                $action = $ch;
                $imgId = 0;
            }
        }
        return $temp;
    }

    private function UpdateImage($str, $monId, $imgNum)
    {
        $temp = $this->UpdateImageParser($str, $imgNum);
        $id = 0;
        foreach ($temp as $k => $v) {
            $url = "img/$monId/$k.jpg";
            if (Storage::disk()->exists($url)) {
                if ($v == 'r') {
                    Storage::disk()->delete($url);
                    $id--;
                } else if ($id != $k) {
                    $newUrl = "img/$monId/$id.jpg";
                    if (!Storage::disk()->exists($newUrl)) {
                        Storage::disk()->move($url, $newUrl);
                    }
                }
                $id++;
            }
        }
        return $id;
    }
}
