<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    /**
     * @return Game
     */
    public function store(): Game
    {
        $game = new Game();

        $game->save();

        return $game;
    }

    /**
     * @param int $game_id
     * @param int $winner_id
     * @return Game
     */
    public function update(int $game_id, int $winner_id): Game
    {
        /** @var Game $game */
        $game = Game::find($game_id);

        $game->winner_id = $winner_id;
        $game->end_date = time();

        $game->save();

        return $game;
    }
}