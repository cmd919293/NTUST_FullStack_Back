<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{

    protected $fillable = [
        'email',
        'token',
    ];
    protected $table = "password_resets";
}
