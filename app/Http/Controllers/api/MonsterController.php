<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\DB;
use App\AttributeName;
use App\Http\Resources\MonsterResource;
use App\MonsterAttributes;
use App\MonsterName;
use App\Monsters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonsterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(null, 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response(null, 404);
    }


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
        foreach ($arr as $v) {
            if (intval($v) == 0) {
                $orderList[] = trim($v);
            } else {
                $filterList[] = intval($v);
            }
        }
        $preQuery = MonsterAttributes::query();
        if (count($filterList) != 0) $preQuery = $preQuery->whereIn('AttributeID', $filterList);
        $preQuery = $preQuery->select('MonsterId')->distinct();
        $monQuery = Monsters::query()
            ->joinSub($preQuery, 'MonsterAttributes',
                'Monsters.id', '=', 'MonsterAttributes.MonsterId');
        foreach ($orderList as $v) {
            if ($v == 'newest') {
                $monQuery = $monQuery->orderBy('Monsters.created_at', 'DESC');
            } else if ($v == 'cheapest') {
                $monQuery = $monQuery->orderBy(DB::raw('Monsters.price * Monsters.discount / 100'), 'ASC');
            } else if ($v == 'hottest') {
                $monQuery = $monQuery->orderBy('Monsters.sold', 'DESC');
            } else if (strpos($v, 'price') === 0) {
                $filterPriceRange = explode('-', substr($v, 6));
                $filterPrice = sort($filterPriceRange, SORT_NUMERIC) && (count($filterPriceRange) == 2);
            }
        }
        if ($filterPrice) {
            $monQuery = $monQuery->whereBetween('price', $filterPriceRange);
        }
        return $monQuery;
    }

    /**
     * Display the specified resource.
     *
     * @param  string $fsStr
     * @param  int $startId
     * @param  int $endId
     * @return array $data
     */
    public function show($fsStr = '*', $startId = 0, $endId = 0)
    {
        $startId = intval($startId);
        $endId = intval($endId);
        if ($startId > $endId || $startId < 0 || $endId < 0) {
            return response(null, 404);
        }
        $data = [];
        $mon = $this->initQuery($fsStr)->skip($startId)
            ->take($endId - $startId + 1)
            ->join('MonsterName', 'monsters.id', '=', 'monstername.id')
            ->select('MonsterName.*', 'Monsters.*')
            ->get();
        foreach ($mon as $i) {
            $attr = MonsterAttributes::where('MonsterId', $i['id'])
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
                'attributes' => []
            ];
            foreach ($attr as $j) {
                $attrLang = [];
                foreach ($j->getAttributes() as $k => $v) {
                    if (strpos(strtolower($k), 'name') === 0) {
                        $attrLang[$k] = $v;
                    }
                }
                array_push($result['attributes'], $attrLang);
            }
            array_push($data, $result);
        }
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response(null, 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(null, 404);
    }
}
