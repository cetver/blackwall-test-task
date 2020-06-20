<?php declare(strict_types=1);

namespace App\Repositories;

use App\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * The "GameRepository" class
 */
class GameRepository implements GameRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findById(string $id): Game
    {
        return Game::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findActiveById(string $id): Game
    {
        $game = $this->findById($id);
        if ($game->finished_at !== null) {
            $message = sprintf('The "%s" attribute of the "%s" model is not null', 'finished_at', Game::class);
            throw new ModelNotFoundException($message);
        }

        return $game;
    }
}
