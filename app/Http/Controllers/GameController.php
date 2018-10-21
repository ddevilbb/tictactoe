<?php

namespace App\Http\Controllers;

use App;
use App\Events\Play;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->gameService = App::make(GameService::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function newGame(Request $request)
    {
        $user = $request->user();
        $game = $this->gameService->store($user->id);

        if ($user->sign === 'o') {
            event(new Play($game->id, 'x'));
        }
        
        return redirect(route('show_game', [
            'id' => $game->id
        ]));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGame(Request $request, int $id)
    {
        $game = $this->gameService->find($id);
        $user = $request->user();
        $board = $this->gameService->prepareBoard($game->id);

        return view('board', compact('game', 'user', 'board'));
    }
}