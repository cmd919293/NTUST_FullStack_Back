<?php

namespace App\Http\Controllers\api;

use App\AttributeName;
use App\Http\Controllers\Controller;

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
}
