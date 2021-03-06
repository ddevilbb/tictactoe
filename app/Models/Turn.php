<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    public $incrementing = false;
    public $fillable = ['game_id', 'player_id', 'player_sign', 'location'];

    /**
     * Get game entity
     */
    public function getGame()
    {
        $this->belongsTo('App\Models\Game', 'game_id');
    }
}