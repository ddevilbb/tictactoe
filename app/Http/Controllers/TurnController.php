<?php

namespace App\Http\Controllers;

use App;
use App\Events\GameOver;
use App\Events\Play;
use App\Services\GameOverService;
use App\Services\GameService;
use App\Services\PlayerService;
use App\Services\TurnService;
use Illuminate\Http\Request;

class TurnController extends Controller
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
     * TurnController constructor.
     */
    public function __construct()
    {
        $this->turnService = App::make(TurnService::class);
        $this->gameService = App::make(GameService::class);
        $this->playerService = App::make(PlayerService::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function makeTurn(Request $request)
    {
        $game_id = $request->post('game_id');
        $player_id = $request->post('player_id');
        $player_sign = $request->post('player_sign');
        $location = $request->post('location');

        $turn = $this->turnService->store($game_id, $player_id, $player_sign, $location);

        if (!$this->gameService->isGameOver($game_id)) {
            $ai_player_sign = $this->playerService->getOtherPlayerSign($player_sign);

            event(new Play($game_id, $ai_player_sign));
        } else {
            $status = $this->gameService->getGameStatus($game_id, $player_sign);

            $this->gameService->update($game_id, $status);
            
            event(new GameOver($game_id, $status));
        }

        return response()->json($turn);
    }
}