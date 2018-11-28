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
}
