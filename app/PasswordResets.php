<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    protected $fillable = [
        'email'
    ];
    protected $table = "password_resets";
}
