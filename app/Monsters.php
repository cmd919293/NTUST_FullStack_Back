<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monsters extends Model
{
    protected $table = "monsters";

    protected $fillable = [
        'ATTACK',
        'DEFENSE',
        'HP',
        'NAME',
        'NAME_EN',
        'NAME_JP',
        'SPEED',
        'SP_ATTACK',
        'SP_DEFENSE',
        'description',
        'price',
        'imgNum',
    ];
    public const INS_RULE = [
        'ATTACK' => 'required|numeric|min:0',
        'DEFENSE' => 'required|numeric|min:0',
        'HP' => 'required|numeric|min:0',
        'NAME' => 'required|string|min:1|unique:MonsterName',
        'NAME_EN' => 'required|string|min:1|unique:MonsterName',
        'NAME_JP' => 'required|string|min:1|unique:MonsterName',
        'SPEED' => 'required|numeric|min:0',
        'SP_ATTACK' => 'required|numeric|min:0',
        'SP_DEFENSE' => 'required|numeric|min:0',
        'description' => 'required|string',
        'price' => 'required|numeric|min:1',
        'attributes' => 'required|array',
        'image' => 'required|array'
    ];
}
