<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Modules\User\Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'image',
        'password',
        'mobile',
        'status',
        'mobile_verified_at'
    ];

    // protected static function newFactory(): UserFactory
    // {
    //     // return UserFactory::new();
    // }
}
