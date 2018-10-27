<?php

namespace App\Http\Controllers;

use App;
use App\Events\Play;
use App\Models\Player;
use App\Services\GameService;
use App\Services\PlayerService;
use Illuminate\Http\Request;

class GameController extends Controller
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
     * GameController constructor.
     */
    public function __construct()
    {
        $this->gameService = App::make(GameService::class);
        $this->playerService = App::make(PlayerService::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selectParameters(Request $request)
    {
        return view('select-parameters');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveParameters(Request $request)
    {
        $this->playerService->saveSign($request->post('sign'));
        $request->session()->put('difficulty', $request->post('difficulty'));

        return redirect(route('new_game'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function newGame(Request $request)
    {
        $user = $request->user();
        $game = $this->gameService->store($user->id, $request->session()->get('difficulty'));

        if ($user->sign === Player::SIGN_O) {
            event(new Play($game->id, Player::SIGN_X));
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