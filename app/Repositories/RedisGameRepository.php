<?php declare(strict_types=1);

namespace App\Repositories;

use App\Caches\CachePrefixInterface;
use App\Caches\CacheTtlInterface;
use App\Game;
use Illuminate\Cache\CacheManager;

/**
 * The "RedisGameRepository" interface
 */
class RedisGameRepository implements GameRepositoryInterface, CachePrefixInterface, CacheTtlInterface
{
    /**
     * @var CacheManager
     */
    private CacheManager $cacheManager;
    /**
     * @var GameRepositoryInterface
     */
    private GameRepositoryInterface $repository;

    public function __construct(CacheManager $cacheManager, GameRepositoryInterface $repository)
    {
        $this->cacheManager = $cacheManager;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): Game
    {
        $cacheKey = $this->cachePrefix() . $id;

        return $this->cacheManager->remember(
            $cacheKey,
            $this->cacheTtl(),
            function () use ($id) {
                return $this->repository->findById($id);
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function findActiveById(string $id): Game
    {
        $cacheKey = $this->cachePrefix() . $id;

        return $this->cacheManager->remember(
            $cacheKey,
            $this->cacheTtl(),
            function () use ($id) {
                return $this->repository->findActiveById($id);
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function cacheTtl(): int
    {
        return 3600;
    }

    /**
     * @inheritDoc
     */
    public function cachePrefix(): string
    {
        return Game::class . CachePrefixInterface::SEPARATOR;
    }
}
