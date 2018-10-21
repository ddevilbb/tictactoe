<?php

namespace App\Http\Controllers;

use App;
use App\Events\GameOver;
use App\Events\Play;
use App\Services\GameOverService;
use App\Services\GameService;
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
     * TurnController constructor.
     */
    public function __construct()
    {
        $this->turnService = App::make(TurnService::class);
        $this->gameService = App::make(GameService::class);
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
        $player_type = $request->post('player_type');
        $location = $request->post('location');

        $turn = $this->turnService->store($game_id, $player_id, $player_type, $location);

        if (!$this->gameService->isGameOver($game_id)) {
            $ai_player_type = $player_type === 'x' ? 'o' : 'x';

            event(new Play($game_id, $ai_player_type));
        } else {
            $status = $this->gameService->getGameStatus($game_id, $player_type);

            $this->gameService->update($game_id, $status);
            
            event(new GameOver($game_id, $status));
        }

        return response()->json($turn);
    }
}