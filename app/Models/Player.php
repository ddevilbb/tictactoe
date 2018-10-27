<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class Player extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const SIGN_X = 'x';
    const SIGN_O = 'o';

    const PLAYER_TYPE_AI = 'ai';
    const PLAYER_TYPE_HUMAN = 'human';

    /**
     * @var array
     */
    protected $fillable = ['type', 'sign', 'score'];

    /**
     * @var array
     */
    protected $hidden = ['remember_token'];
}