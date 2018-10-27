<?php

namespace App\Providers;

use App\Contexts\AIPlayerContext;
use App\Players\AIEasyPlayer;
use App\Players\AIHardPlayer;
use App\Services\AITurnService;
use App\Services\GameOverService;
use App\Services\GameService;
use App\Services\PlayerService;
use App\Services\TurnService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Http/Helpers/DataHelper.php';

        $this->app->singleton(PlayerService::class, function () {
            return new PlayerService();
        });

        $this->app->singleton(TurnService::class, function () {
            return new TurnService();
        });

        $this->app->singleton(AIPlayerContext::class, function () {
            return new AIPlayerContext(Session::get('difficulty'));
        });

        $this->app->singleton(GameService::class, function ($app) {
            return new GameService($app->make(TurnService::class), $app->make(PlayerService::class));
        });
        
        $this->app->singleton(AITurnService::class, function ($app) {
            return new AITurnService(
                $app->make(TurnService::class),
                $app->make(GameService::class),
                $app->make(PlayerService::class),
                $app->make(AIPlayerContext::class)
            );
        });
        
        $this->app->singleton(AIEasyPlayer::class, function ($app) {
            return new AIEasyPlayer($app->make(GameService::class));
        });

        $this->app->singleton(AIHardPlayer::class, function ($app) {
            return new AIHardPlayer($app->make(GameService::class), $app->make(PlayerService::class));
        });
    }
}
