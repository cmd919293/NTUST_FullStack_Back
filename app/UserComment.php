<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    protected $table = "user_comment";
    protected $fillable = [
        'UserId',
        'ProductId',
        'Comment'
    ];
}
