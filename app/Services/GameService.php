<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Player;
use DateTime;

class GameService
{
    /**
     * @var TurnService
     */
    private $turnService;

    /**
     * @var PlayerService
     */
    private $playerService;

    /**
     * GameService constructor.
     *
     * @param TurnService $turnService
     * @param PlayerService $playerService
     */
    public function __construct(TurnService $turnService, PlayerService $playerService)
    {
        $this->turnService = $turnService;
        $this->playerService = $playerService;
    }

    /**
     * @param int $player_id
     * @param string $difficulty
     * @return Game
     * @throws \Throwable
     */
    public function store(int $player_id, string $difficulty): Game
    {
        $game = new Game();

        $game->player_id = $player_id;
        $game->difficulty = $difficulty;

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

        if ($this->checkWinCombinations($board, Player::SIGN_X) ||
            $this->checkWinCombinations($board, Player::SIGN_O) ||
            count($availTurns) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $game_id
     * @param string $player_sign
     * @return string
     */
    public function getGameStatus(int $game_id, string $player_sign): string
    {
        $board = $this->prepareBoard($game_id);

        $other_player_sign = $this->playerService->getOtherPlayerSign($player_sign);

        if ($this->checkWinCombinations($board, $player_sign)) {
            return Game::STATUS_WIN;
        } elseif ($this->checkWinCombinations($board, $other_player_sign)) {
            return Game::STATUS_LOOSE;
        } else {
            return Game::STATUS_TIE;
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
                $board[$turn['location']] = (string) $turn['player_sign'];
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
            return $sign !== Player::SIGN_X && $sign !== Player::SIGN_O;
        });
    }

    /**
     * @param array $board
     * @param string $sign
     * @return bool
     */
    public function checkWinCombinations(array $board, string $sign): bool
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
            if ($board[$combination[0]] === $sign &&
                $board[$combination[1]] === $board[$combination[0]] &&
                $board[$combination[2]] === $board[$combination[0]]) {
                return true;
            }
        }

        return false;
    }
}