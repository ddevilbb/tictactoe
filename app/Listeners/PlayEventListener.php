<?php

namespace App\Listeners;

use App;
use App\Events\Play;
use App\Services\AITurnService;

class PlayEventListener
{
    /**
     * @var AITurnService
     */
    private $aiTurnService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->aiTurnService = App::make(AITurnService::class);
    }

    /**
     * Handle the event.
     *
     * @param Play $event
     * @return void
     * @throws \Throwable
     */
    public function handle(Play $event)
    {
        $this->aiTurnService->makeTurn($event->game_id, $event->ai_player_sign);
    }
}
