<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class PlayerService
{
    /**
     * @return Player
     * @throws \Throwable
     */
    public function store(): Player
    {
        $player = new Player();

        $player->type = Player::PLAYER_TYPE_HUMAN;

        $player->saveOrFail();

        return $player;
    }

    /**
     * @param $sign
     */
    public function saveSign($sign): void
    {
        $player = Auth::user();

        $player->sign = $sign;

        $player->save();

        return;
    }

    /**
     * @param string $sign
     * @return string
     */
    public function getOtherPlayerSign(string $sign): string
    {
        return $sign === Player::SIGN_X ? Player::SIGN_O : Player::SIGN_X;
    }
}