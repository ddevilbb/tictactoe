<?php

namespace App\Services;

use App\Models\Game;
use DateTime;

class GameService
{
    /**
     * @var TurnService
     */
    private $turnService;

    /**
     * GameService constructor.
     */
    public function __construct(TurnService $turnService)
    {
        $this->turnService = $turnService;
    }

    /**
     * @param int $player_id
     * @return Game
     * @throws \Throwable
     */
    public function store(int $player_id): Game
    {
        $game = new Game();

        $game->player_id = $player_id;

        $game->saveOrFail();

        return $game;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function find(int $id): Game
    {
        return Game::findOrFail($id);
    }

    public function findBy(array $params)
    {
        return Game::with('turns')->where($params)->get();
    }

    /**
     * @param int $id
     * @param string $status
     * @return Game
     * @throws \Throwable
     */
    public function update(int $id, string $status): Game
    {
        /** @var Game $game */
        $game = Game::findOrFail($id);

        $game->status = $status;
        $game->end_date = new DateTime();

        $game->saveOrFail();

        return $game;
    }

    /**
     * @param int $game_id
     * @return bool
     */
    public function isGameOver(int $game_id): bool
    {
        $board = $this->prepareBoard($game_id);
        $availTurns = $this->getAvailTurns($board);

        $signX = 'x';
        $signO = 'o';

        if ($this->checkWinCombinations($board, $signX) ||
            $this->checkWinCombinations($board, $signO) ||
            count($availTurns) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $game_id
     * @param string $player
     * @return string
     */
    public function getGameStatus(int $game_id, string $player): string
    {
        $board = $this->prepareBoard($game_id);

        $otherPlayer = $player == 'x' ? 'o' : 'x';

        if ($this->checkWinCombinations($board, $player)) {
            return 'win';
        } elseif ($this->checkWinCombinations($board, $otherPlayer)) {
            return 'loose';
        } else {
            return 'tie';
        }
    }

    /**
     * @param int $game_id
     * @return array
     */
    public function prepareBoard(int $game_id): array
    {
        $board = [0, 1, 2, 3, 4, 5, 6, 7, 8];

        $turns = $this->turnService->findByGameId($game_id);

        if (!empty($turns)) {
            foreach ($turns as $turn) {
                $board[$turn['location']] = (string) $turn['player_type'];
            }
        }

        return $board;
    }

    /**
     * @param array $board
     * @return array
     */
    public function getAvailTurns(array $board): array
    {
        return array_filter($board, function ($sign) {
            return $sign !== 'x' && $sign !== 'o';
        });
    }

    /**
     * @param array $board
     * @param string $player
     * @return bool
     */
    public function checkWinCombinations(array $board, string $player): bool
    {
        $combinations = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6]
        ];

        foreach ($combinations as $combination) {
            if ($board[$combination[0]] === $player &&
                $board[$combination[1]] === $player &&
                $board[$combination[2]] === $player) {
                return true;
            }
        }

        return false;
    }
}