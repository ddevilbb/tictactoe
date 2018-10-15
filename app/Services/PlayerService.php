<?php

namespace App\Services;

use App\Models\Player;

class PlayerService
{
    /**
     * @return Player
     */
    public function store(): Player
    {
        $player = new Player();

        $player->type = 'human';

        $player->save();

        return $player;
    }
}