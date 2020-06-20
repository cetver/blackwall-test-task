<?php declare(strict_types=1);

namespace App\Repositories;

use App\Game;

/**
 * The "GameRepositoryInterface" interface
 */
interface GameRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return Game
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(string $id): Game;

    /**
     * @param string $id
     *
     * @return Game
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findActiveById(string $id): Game;
}
