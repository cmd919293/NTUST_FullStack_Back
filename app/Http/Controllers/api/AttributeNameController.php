<?php

namespace App\Http\Controllers\api;

use App\AttributeName;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeNameController extends Controller
{
    public function index()
    {
        $attrs = AttributeName::query()->get()->toArray();
        for ($i = 0; $i < count($attrs); $i++) {
            $attrs[$i]['value'] = $attrs[$i]['id'];
            unset($attrs[$i]['id'], $attrs[$i]['created_at'], $attrs[$i]['updated_at']);
        }
        return response()->json($attrs, 200);
    }

    public function show($id)
    {
        $attr = AttributeName::query()->where('id', $id)->get()->toArray();
        if (count($attr)) {
            $attr = $attr[0];
            unset($attr['created_at'], $attr['updated_at']);
        }
        return $attr;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), AttributeName::INS_RULE);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        AttributeName::query()->create([
            'NAME' => $request['NAME'],
            'NAME_EN' => $request['NAME_EN'],
            'NAME_JP' => $request['NAME_JP']
        ]);
        return response()->json([
            'status' => true,
            'message' => [
                'Data' => 'Insert Success'
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), AttributeName::UPDATE_RULE);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $attrId = $request['id'];
        $checkName = AttributeName::query()->orWhere([
            'NAME' => $request['NAME'],
            'NAME_JP' => $request['NAME_JP'],
            'NAME_EN' => $request['NAME_EN'],
        ])->get();
        if ($checkName->isNotEmpty()) {
            if ($checkName->count() > 1 || $checkName[0]['id'] != $attrId) {
                $msg = [];
                if (AttributeName::query()->orWhere(['NAME' => $request['NAME'], 'id' => $attrId])->count() > 1) {
                    $msg['NAME'] = 'This NAME is exists.';
                }
                if (AttributeName::query()->orWhere(['NAME_JP' => $request['NAME_JP'], 'id' => $attrId])->count() > 1) {
                    $msg['NAME_JP'] = 'This NAME_JP is exists.';
                }
                if (AttributeName::query()->orWhere(['NAME_EN' => $request['NAME_EN'], 'id' => $attrId])->count() > 1) {
                    $msg['NAME_EN'] = 'This NAME_EN is exists.';
                }
                return response()->json([
                    'status' => false,
                    'message' => $msg
                ], 400);
            }
        }
        AttributeName::query()->where(['id' => $attrId])
            ->update([
                'NAME' => $request['NAME'],
                'NAME_EN' => $request['NAME_EN'],
                'NAME_JP' => $request['NAME_JP']
            ]);
        return response()->json([
            'status' => true,
            'message' => [
                'Data' => 'Update Success'
            ]
        ]);
    }

    public function destroy($id)
    {
        AttributeName::query()->where(['id' => $id])->delete();
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }
}
