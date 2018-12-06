<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupon";

    protected $dates = [
        'expired_at'
    ];

    protected $fillable = [
        'Name',
        'UserId',
        'OrderId',
        'Discount',
        'Token',
        'expired_at',
        'Owned',
        'Used'
    ];

    public function User(){
        return $this->belongsTo(User::class,'UserId','id');
    }

    public function Order(){
        return $this->belongsTo(Order::class,'OrderId','id');
    }
}
