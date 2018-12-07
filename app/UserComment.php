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

    public function User(){
        return $this->belongsTo(User::class,'UserId','id');
    }
    public function Product(){
        return $this->belongsTo(Monsters::class,'ProductId','id');
    }
}
