<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = "orderItem";
    protected $fillable = [
        'OrderID',
        'UserID',
        'ProductID',
        'Count',
        'Price',
    ];
}
