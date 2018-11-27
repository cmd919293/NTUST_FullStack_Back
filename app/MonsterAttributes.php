<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonsterAttributes extends Model
{
    protected $table = "MonsterAttributes";
    protected $fillable = [
        'MonsterId',
        'AttributeId',
    ];
}
