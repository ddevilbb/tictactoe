<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const DIFFICULTY_EASY = 'easy';
    const DIFFICULTY_HARD = 'hard';

    const STATUS_WIN = 'win';
    const STATUS_LOOSE = 'loose';
    const STATUS_TIE = 'tie';

    public $fillable = ['player_id', 'status', 'difficulty', 'end_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function turns()
    {
        return $this->hasMany('App\Models\Turn', 'game_id');
    }
}