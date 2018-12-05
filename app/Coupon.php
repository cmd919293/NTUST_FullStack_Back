<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupon";
    protected $fillable = [
        'UserId',
        'OrderId',
        'Discount',
        'Token',
        'expire_at',
        'Owned',
        'Used'
    ];
}
