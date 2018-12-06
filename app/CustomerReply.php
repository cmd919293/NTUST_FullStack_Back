<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerReply extends Model
{
    protected $table = "CustomerReply";
    protected $fillable = [
        'userID','imageNum','resolved',
    ];



    public function User(){
        return $this->belongsTo(User::class,'userID','id');
    }

}
