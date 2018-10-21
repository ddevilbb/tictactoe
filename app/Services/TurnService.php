<?php

namespace App\Services;

use App\Models\Turn;

class TurnService
{
    /**
     * @param int $game_id
     * @param int $player_id
     * @param string $player_type
     * @param int $location
     * @return mixed
     * @throws \Throwable
     */
    public function store(int $game_id, int $player_id, string $player_type, int $location): Turn
    {
        $turn = new Turn();

        $turn->game_id = $game_id;
        $turn->player_id = $player_id;
        $turn->player_type = $player_type;
        $turn->location = $location;

        $turn->saveOrFail();

        return $turn;
    }

    /**
     * @param int $game_id
     * @return mixed
     */
    public function findByGameId(int $game_id): array
    {
        return Turn::where('game_id', $game_id)->get()->toArray();
    }

    /**
     * @param int $game_id
     * @return int
     */
    public function getCountByGameId(int $game_id): int
    {
        return Turn::where('game_id', $game_id)->count();
    }
}