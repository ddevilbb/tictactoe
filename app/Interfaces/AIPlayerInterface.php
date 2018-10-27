<?php

namespace App\Interfaces;

interface AIPlayerInterface
{
    /**
     * @param int $game_id
     * @param string $player_sign
     * @return mixed
     */
    public function getLocation(int $game_id, string $player_sign): int;
}