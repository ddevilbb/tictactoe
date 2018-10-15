<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class Player extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * @var array
     */
    protected $fillable = ['type', 'score'];

    /**
     * @var array
     */
    protected $hidden = ['remember_token'];
}