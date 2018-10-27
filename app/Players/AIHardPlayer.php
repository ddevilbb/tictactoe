<?php

namespace App\Players;

use App\Interfaces\AIPlayerInterface;
use App\Models\Player;
use App\Services\GameService;
use App\Services\PlayerService;

class AIHardPlayer implements AIPlayerInterface
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * @var PlayerService
     */
    private $playerService;

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

    /**
     * AIHardPlayer constructor.
     *
     * @param GameService $gameService
     * @param PlayerService $playerService
     */
    public function __construct(GameService $gameService, PlayerService $playerService)
    {
        $this->gameService = $gameService;
        $this->playerService = $playerService;
        $this->min = -10;
        $this->max = 10;
    }

    /**
     * @param int $game_id
     * @param string $player_sign
     * @return int
     */
    public function getLocation(int $game_id, ?string $player_sign): int
    {
        $board = $this->gameService->prepareBoard($game_id);

        $this->aiPlayer = $player_sign;
        $this->huPlayer = $this->playerService->getOtherPlayerSign($player_sign);

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

        if ($this->gameService->checkWinCombinations($board, $this->huPlayer)) {
            return [
                'score' => round($this->min / $step),
                'step' => $step
            ];
        } elseif ($this->gameService->checkWinCombinations($board, $this->aiPlayer)) {
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
}