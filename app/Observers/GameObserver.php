<?php declare(strict_types=1);

namespace App\Observers;

use App\Caches\CachePrefixInterface;
use App\Game;
use App\Generators\Uuid4GeneratorInterface;
use App\Serializers\Encoders\PostgresArrayEncoder;
use App\Serializers\Normalizers\PostgresArrayNormalizer;
use Illuminate\Cache\CacheManager;
use Symfony\Component\Serializer\SerializerInterface;

class GameObserver implements CachePrefixInterface
{
    /**
     * @var Uuid4GeneratorInterface
     */
    private Uuid4GeneratorInterface $uuid4Generator;
    /**
     * @var CacheManager
     */
    private CacheManager $cacheManager;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * GameObserver constructor.
     *
     * @param Uuid4GeneratorInterface $uuid4Generator
     * @param CacheManager $cacheManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Uuid4GeneratorInterface $uuid4Generator,
        CacheManager $cacheManager,
        SerializerInterface $serializer
    )
    {
        $this->uuid4Generator = $uuid4Generator;
        $this->cacheManager = $cacheManager;
        $this->serializer = $serializer;
    }

    /**
     * Handle the game "creating" event.
     *
     * @param Game $model
     */
    public function creating(Game $model)
    {
        $model->id = $this->uuid4Generator->generate();
    }

    /**
     * Handle the game "created" event.
     *
     * @param Game $model
     */
    public function created(Game $model)
    {
        $model->tiles = $this->serializer->deserialize(
            $model->tiles,
            PostgresArrayNormalizer::TYPE,
            PostgresArrayEncoder::FORMAT
        );
    }

    /**
     * Handle the game "updated" event.
     *
     * @param Game $model
     */
    public function updated(Game $model)
    {
        $cacheKey = $this->cachePrefix() . $model->id;
        $this->cacheManager->forget($cacheKey);
    }

    /**
     * Handle the game "saving" event.
     *
     * @param Game $model
     */
    public function saving(Game $model)
    {
        $model->tiles = $this->serializer->serialize($model->tiles, PostgresArrayEncoder::FORMAT);
    }

    /**
     * Handle the game "retrieved" event.
     *
     * @param Game $model
     */
    public function retrieved(Game $model)
    {
        $model->tiles = $this->serializer->deserialize(
            $model->tiles,
            PostgresArrayNormalizer::TYPE,
            PostgresArrayEncoder::FORMAT
        );
    }

    /**
     * @inheritDoc
     */
    public function cachePrefix(): string
    {
        return Game::class . CachePrefixInterface::SEPARATOR;
    }
}
