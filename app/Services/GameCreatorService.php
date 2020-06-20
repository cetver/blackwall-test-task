<?php declare(strict_types=1);

namespace App\Services;

use App\Game;
use App\Strategies\OrderedTilesStrategy;
use App\Strategies\RandomTilesStrategy;
use App\Strategies\TilesStrategyInterface;
use App\User;

/**
 * The "GameCreatorService" class
 */
class GameCreatorService
{
    public function create(User $user, string $tiles = ''): Game
    {
        $dto = $this->strategy($tiles)->dto($tiles);
        $game = new Game();
        $game->createFromDto($user, $dto);

        return $game;
    }

    private function strategy(string $tiles): TilesStrategyInterface
    {
        if ($tiles === '') {
            $strategy = app()->get(RandomTilesStrategy::class);
        } elseif ($tiles !== '') {
            $strategy = app()->get(OrderedTilesStrategy::class);
        } else {
            throw new \InvalidArgumentException('There is no suitable strategy');
        }

        return $strategy;
    }
}
