<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonsterName extends Model
{
    protected $table = "monstername";
    protected $fillable = [
        'id',
        'NAME',
        'NAME_EN',
        'NAME_JP',
    ];
}
