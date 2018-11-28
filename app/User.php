<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public const FORGET = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255'
    ];
    public const RESET = [
        'email' => 'required|string|exists:password_resets',
        'token' => 'required|string|exists:password_resets',
        'password' => 'required|string|min:6',
        'confirm_password' => 'required|same:password',
    ];
    public const LOGIN = [
        'email' => 'required|string|exists:users',
        'password' => 'required|string|min:6'
    ];
    public const REGISTER = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
        'confirm_password' => 'required|same:password',
    ];
    public const EDIT_CONFIG = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email',
        'password' => 'string',
        'new_password' => 'string',
        'confirm_password' => 'string|same:new_password',
    ];
    public const CHECK_PWD = [
        'password' => 'string|min:6',
        'new_password' => 'string|min:6',
        'confirm_password' => 'string|same:new_password',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
