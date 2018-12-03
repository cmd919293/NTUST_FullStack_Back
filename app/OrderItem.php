<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = "orderItem";
    protected $fillable = [
        'OrderId',
        'ProductId',
        'Count',
        'Price',
    ];
}
