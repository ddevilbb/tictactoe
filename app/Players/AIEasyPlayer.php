<?php

namespace App\Players;

use App\Interfaces\AIPlayerInterface;
use App\Services\GameService;

class AIEasyPlayer implements AIPlayerInterface
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * AIEasyPlayer constructor.
     *
     * @param GameService $gameService
     */
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @param int $game_id
     * @param string $player_sign
     * @return int
     */
    public function getLocation(int $game_id, string $player_sign): int
    {
        $board = $this->gameService->prepareBoard($game_id);

        return $this->getRandomMove($board);
    }

    /**
     * @param array $board
     * @return int
     */
    private function getRandomMove(array $board): int
    {
        $availTurns = $this->gameService->getAvailTurns($board);

        $randomKey = array_rand($availTurns);

        return $availTurns[$randomKey];
    }
}