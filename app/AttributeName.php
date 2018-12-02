<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeName extends Model
{
    protected $table = "attributeName";
    protected $fillable = [
        'NAME',
        'NAME_EN',
        'NAME_JP',
    ];
    public const INS_RULE = [
        'NAME' => 'required|string|min:1|unique:MonsterName',
        'NAME_EN' => 'required|string|min:1|unique:MonsterName',
        'NAME_JP' => 'required|string|min:1|unique:MonsterName',
    ];
    public const UPDATE_RULE = [
        'id' => 'required|numeric|exists:AttributeName',
        'NAME' => 'required|string|min:1',
        'NAME_EN' => 'required|string|min:1',
        'NAME_JP' => 'required|string|min:1',
    ];
}
