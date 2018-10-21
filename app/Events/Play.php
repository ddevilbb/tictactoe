<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class Play
{
    use SerializesModels;

    /**
     * @var int
     */
    public $game_id;

    /**
     * @var string
     */
    public $ai_player_type;

    /**
     * Create a new event instance.
     *
     * @param int $game_id
     * @param string $ai_player_type
     */
    public function __construct(int $game_id, string $ai_player_type)
    {
        $this->game_id = $game_id;
        $this->ai_player_type = $ai_player_type;
    }
}
