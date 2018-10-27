<?php

namespace App\Contexts;

use App;
use App\Exceptions\WrongDifficultyException;
use App\Interfaces\AIPlayerInterface;
use App\Models\Game;
use App\Players\AIEasyPlayer;
use App\Players\AIHardPlayer;

class AIPlayerContext
{
    /**
     * @var AIPlayerInterface
     */
    private $player;

    /**
     * AIPlayerContext constructor.
     *
     * @param string $difficulty
     * @throws WrongDifficultyException
     */
    public function __construct(string $difficulty)
    {
        switch ($difficulty) {
            case Game::DIFFICULTY_EASY:
                $this->player = App::make(AIEasyPlayer::class);
                break;
            case Game::DIFFICULTY_HARD;
                $this->player = App::make(AIHardPlayer::class);
                break;
            default:
                throw new WrongDifficultyException('Difficulty \'' . $difficulty . '\' is wrong!');
                break;
        }
    }

    /**
     * @param int $game_id
     * @param string $player_sign
     * @return int
     */
    public function makeTurn(int $game_id, string $player_sign): int
    {
        return $this->player->getLocation($game_id, $player_sign);
    }
}