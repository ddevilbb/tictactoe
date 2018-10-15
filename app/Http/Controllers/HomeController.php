<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        //TODO: закомментированные строки добавить в PlayerMiddleware
//        if (!Auth::user()) {
//            $player = Player::create([
//                'type' => 'human',
//                'score' => 0
//            ]);
//
//            Auth::loginUsingId($player->id, true);
//        }
        return view('home');
    }
}