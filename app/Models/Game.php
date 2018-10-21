<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $fillable = ['player_id', 'status', 'end_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function turns()
    {
        return $this->hasMany('App\Models\Turn', 'game_id');
    }
}