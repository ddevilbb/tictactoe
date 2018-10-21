<?php

namespace App\Http\Controllers;

use App;
use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * PlayerController constructor.
     */
    public function __construct()
    {
        $this->gameService = App::make(GameService::class);
    }

    public function selectSign(Request $request)
    {
        return view('select-sign');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveSign(Request $request)
    {
        $user = Auth::user();

        $user->sign = $request->post('sign');

        $user->save();

        return redirect(route('new_game'));
    }

    public function getHistory(Request $request)
    {
        $user = Auth::user();

        $games = $this->gameService->findBy(['player_id' => $user->id]);

        $view = view('history', compact('games', 'user'))->render();

        return response()->json([
            'title' => 'История игр',
            'data' => $view
        ]);
    }
}