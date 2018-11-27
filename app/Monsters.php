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
        'attributes',
    ];
    public const INS_RULE = [
        'ATTACK' => 'numeric|min:0',
        'DEFENSE' => 'numeric|min:0',
        'HP' => 'numeric|min:0',
        'NAME' => 'string|min:1',
        'NAME_EN' => 'string|min:1|unique:MonsterName',
        'NAME_JP' => 'string|min:1',
        'SPEED' => 'numeric|min:0',
        'SP_ATTACK' => 'numeric|min:0',
        'SP_DEFENSE' => 'numeric|min:0',
        'description' => 'string',
        'price' => 'numeric|min:1',
        'attributes' => 'array'
    ];
}
