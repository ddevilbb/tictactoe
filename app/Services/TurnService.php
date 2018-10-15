<?php

namespace App\Services;

use App\Models\Turn;

class TurnService
{
    /**
     * @param int $id
     * @param int $game_id
     * @param int $player_id
     * @param string $player_type
     * @param int $location
     * @return mixed
     */
    public function store(int $id, int $game_id, int $player_id, string $player_type, int $location): Turn
    {
        $turn = new Turn();

        $turn->id = $id;
        $turn->game_id = $game_id;
        $turn->player_id = $player_id;
        $turn->player_type = $player_type;
        $turn->location = $location;

        $turn->save();

        return $turn;
    }

    /**
     * @param int $game_id
     * @return mixed
     */
    public function findByGameId(int $game_id): array
    {
        return Turn::where('game_id', $game_id)->get();
    }
}