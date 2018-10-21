<?php

namespace App\Http\Middleware;

use App;
use App\Services\PlayerService;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth as Auth;

class PlayerAuthMiddleware extends Middleware
{
    /**
     * @var PlayerService
     */
    private $playerService;

    public function __construct(AuthFactory $auth)
    {
        parent::__construct($auth);

        $this->playerService = App::make(PlayerService::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::user()) {
            $player = $this->playerService->store();

            Auth::loginUsingId($player->id, false);
        }

        return $next($request);
    }
}