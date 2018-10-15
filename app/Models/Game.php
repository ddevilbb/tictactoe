<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $fillable = ['winner_id', 'end_date'];
    public function getTurns()
    {
        return $this->hasMany('App\Models\Turn', 'game_id');
    }
}