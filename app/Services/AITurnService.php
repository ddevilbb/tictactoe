<?php

namespace App\Services;

use App;
use App\Events\AIPlay;
use App\Events\GameOver;

class AITurnService 
{
    /**
     * @var TurnService
     */
    private $turnService;

    /**
     * @var GameService
     */
    private $gameService;

    /**
     * @var string
     */
    private $aiPlayer;

    /**
     * @var string
     */
    private $huPlayer;

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    public function __construct(TurnService $turnService, GameService $gameService)
    {
        $this->turnService = $turnService;
        $this->gameService = $gameService;
        $this->min = -10;
        $this->max = 10;
    }

    /**
     * @param int $game_id
     * @param string $player_type
     * @throws \Throwable
     */
    public function makeTurn(int $game_id, string $player_type)
    {
        $player_id = 1;
        $location = $this->getLocation($game_id, $player_type);

        $this->turnService->store($game_id, $player_id, $player_type, $location);

        event(new AIPlay($game_id, $player_id, $location, $player_type));

        if ($this->gameService->isGameOver($game_id)) {
            $otherPlayerType = $player_type == 'x' ? 'o' : 'x';

            $status = $this->gameService->getGameStatus($game_id, $otherPlayerType);

            $this->gameService->update($game_id, $status);

            event(new GameOver($game_id, $status));
        }

        return;
    }

    /**
     * @param int $game_id
     * @param string $player_type
     * @return int
     */
    public function getLocation(int $game_id, string $player_type): int
    {
        $board = $this->gameService->prepareBoard($game_id);

        $this->aiPlayer = $player_type;
        $this->huPlayer = $player_type === 'x' ? 'o' : 'x';

        $bestMove = $this->minimax($board, $this->aiPlayer, 1);

        return $bestMove['index'];
    }

    /**
     * @param array $board
     * @param string $player
     * @param int $step
     * @return array|mixed|null
     */
    private function minimax(array $board, string $player, int $step)
    {
        $availTurns = $this->gameService->getAvailTurns($board);

        if ($this->checkForWin($board, $this->huPlayer)) {
            return [
                'score' => round($this->min / $step),
                'step' => $step
            ];
        } elseif ($this->checkForWin($board, $this->aiPlayer)) {
            return [
                'score' => round($this->max / $step),
                'step' => $step
            ];
        } elseif (count($availTurns) === 0) {
            return [
                'score' => 0,
                'step' => $step
            ];
        }

        $moves = [];

        foreach ($availTurns as $turn) {
            $move = [
                'index' => $board[$turn],
                'step' => $step,
            ];

            $board[$turn] = $player;

            if ($player == $this->aiPlayer) {
                $result = $this->minimax($board, $this->huPlayer, $step+1);
                $move['score'] = $result['score'];
                $move['step'] = $result['step'];
            } else {
                $result = $this->minimax($board, $this->aiPlayer, $step+1);
                $move['score'] = $result['score'];
                $move['step'] = $result['step'];
            }

            $board[$turn] = $move['index'];

            $moves[] = $move;
        }

        if ($player === $this->aiPlayer) {
            $bestScore = -10000;
            foreach ($moves as $i => $move) {
                if ($move['score'] > $bestScore) {
                    $bestScore = $move['score'];
                    $bestMove = $i;
                }
            }
        } else {
            $bestScore = 10000;
            foreach ($moves as $i => $move) {
                if ($move['score'] < $bestScore) {
                    $bestScore = $move['score'];
                    $bestMove = $i;
                }
            }
        }

        return isset($bestMove) ? $moves[$bestMove] : null;
    }

    /**
     * @param array $board
     * @param string $player
     * @return bool
     */
    private function checkForWin(array $board, string $player)
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
                $board[$combination[1]] === $board[$combination[0]] &&
                $board[$combination[2]] === $board[$combination[0]]) {
                return true;
            }
        }

        return false;
    }
}