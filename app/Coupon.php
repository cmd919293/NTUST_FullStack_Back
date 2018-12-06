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
        'UserId',
        'OrderId',
        'Discount',
        'Token',
        'expired_at',
        'Owned',
        'Used'
    ];
}
