<?php

namespace App\Providers;

use App\Rules\GameTileRule;
use App\Services\TilesValidatorService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\SerializerInterface;

class RuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            GameTileRule::class,
            function (Application $app) {
                $serializer = $app->get(SerializerInterface::class);
                $tilesValidatorService = $app->get(TilesValidatorService::class);

                return new GameTileRule($serializer, $tilesValidatorService);
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
