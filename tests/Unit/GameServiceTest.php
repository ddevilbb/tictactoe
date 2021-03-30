<?php

namespace Tests\Unit;

use App;
use App\Services\GameService;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    public function testSingleton()
    {
        $service1 = App::make(GameService::class);
        $service2 = App::make(GameService::class);

        $this->assertInstanceOf(GameService::class, $service1);
        $this->assertSame($service1, $service2);
    }
}