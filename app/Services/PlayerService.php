<?php

namespace App\Services;

use App\Models\Player;

class PlayerService
{
    /**
     * @return Player
     * @throws \Throwable
     */
    public function store(): Player
    {
        $player = new Player();

        $player->type = 'human';

        $player->saveOrFail();

        return $player;
    }
}