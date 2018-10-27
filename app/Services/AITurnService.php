<?php

namespace App\Services;

use App;
use App\Contexts\AIPlayerContext;
use App\Events\AIPlay;
use App\Events\GameOver;
use App\Models\Player;

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
     * @var PlayerService
     */
    private $playerService;

    /**
     * @var AIPlayerContext
     */
    private $aiPlayerContext;

    /**
     * AITurnService constructor.
     *
     * @param TurnService $turnService
     * @param GameService $gameService
     * @param PlayerService $playerService
     * @param AIPlayerContext $aiPlayerContext
     */
    public function __construct(
        TurnService $turnService,
        GameService $gameService,
        PlayerService $playerService,
        AIPlayerContext $aiPlayerContext
    )
    {
        $this->turnService = $turnService;
        $this->gameService = $gameService;
        $this->playerService = $playerService;
        $this->aiPlayerContext = $aiPlayerContext;
    }

    /**
     * @param int $game_id
     * @param string $player_sign
     * @throws \Throwable
     */
    public function makeTurn(int $game_id, string $player_sign)
    {
        $player_id = 1;

        $location = $this->aiPlayerContext->makeTurn($game_id, $player_sign);

        $this->turnService->store($game_id, $player_id, $player_sign, $location);

        event(new AIPlay($game_id, $player_id, $location, $player_sign));

        if ($this->gameService->isGameOver($game_id)) {
            $other_player_sign = $this->playerService->getOtherPlayerSign($player_sign);

            $status = $this->gameService->getGameStatus($game_id, $other_player_sign);

            $this->gameService->update($game_id, $status);

            event(new GameOver($game_id, $status));
        }

        return;
    }


}