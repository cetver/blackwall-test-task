<?php

namespace App\Observers;

use App\Generators\Uuid4GeneratorInterface;
use App\Move;
use App\Serializers\Encoders\PostgresArrayEncoder;
use App\Serializers\Normalizers\PostgresArrayNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * The "MoveObserver" class
 */
class MoveObserver
{
    /**
     * @var Uuid4GeneratorInterface
     */
    private Uuid4GeneratorInterface $uuid4Generator;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * MoveObserver constructor.
     *
     * @param Uuid4GeneratorInterface $uuid4Generator
     * @param SerializerInterface $serializer
     */
    public function __construct(Uuid4GeneratorInterface $uuid4Generator, SerializerInterface $serializer)
    {
        $this->uuid4Generator = $uuid4Generator;
        $this->serializer = $serializer;
    }

    /**
     * Handle the move "creating" event.
     *
     * @param Move $model
     */
    public function creating(Move $model)
    {
        $model->id = $this->uuid4Generator->generate();
    }

    /**
     * Handle the move "saving" event.
     *
     * @param Move $model
     */
    public function saving(Move $model)
    {
        $model->tiles = $this->serializer->serialize($model->tiles, PostgresArrayEncoder::FORMAT);
    }

    /**
     * Handle the move "retrieved" event.
     *
     * @param Move $model
     */
    public function retrieved(Move $model)
    {
        $model->tiles = $this->serializer->deserialize(
            $model->tiles,
            PostgresArrayNormalizer::TYPE,
            PostgresArrayEncoder::FORMAT
        );
    }
}
