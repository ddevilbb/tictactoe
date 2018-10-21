<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AIPlay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $game_id;

    /**
     * @var int
     */
    public $player_id;

    /**
     * @var int
     */
    public $location;

    /**
     * @var string
     */
    public $sign;

    /**
     * Create a new event instance.
     *
     * @param int $game_id
     * @param int $player_id
     * @param int $location
     * @param string $sign
     */
    public function __construct(int $game_id, int $player_id, int $location, string $sign)
    {
        $this->game_id = $game_id;
        $this->player_id = $player_id;
        $this->location = $location;
        $this->sign = $sign;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('game-channel-' . $this->game_id . '-1');
    }
}
