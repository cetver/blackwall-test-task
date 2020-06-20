<?php

namespace App\Providers;

use App\Game;
use App\Http\Controllers\GamesController;
use App\Move;
use App\Observers\GameObserver;
use App\Observers\MoveObserver;
use App\Observers\UserObserver;
use App\Repositories\GameRepository;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\RedisGameRepository;
use App\User;
use Illuminate\Cache\CacheManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        GameRepository::class => GameRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            RedisGameRepository::class,
            function (Application $app) {
                $cacheManager = $app->get(CacheManager::class);
                $repository = $app->get(GameRepository::class);

                return new RedisGameRepository($cacheManager, $repository);
            }
        );
        $this->app->bind(GameRepositoryInterface::class, RedisGameRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerObservers();
    }

    private function registerObservers()
    {
        User::observe(UserObserver::class);
        Game::observe(GameObserver::class);
        Move::observe(MoveObserver::class);
    }
}
