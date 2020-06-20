<?php declare(strict_types=1);

namespace App\Strategies;

use App\Dto\GameTilesDto;
use App\Serializers\Encoders\GameTilesEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * The "OrderedTilesStrategy" class
 */
class OrderedTilesStrategy implements TilesStrategyInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function dto(string $tiles): GameTilesDto
    {
        $tiles .= '00';
        /** @var GameTilesDto $dto */
        $dto = $this->serializer->deserialize($tiles, GameTilesDto::class, GameTilesEncoder::FORMAT);

        return $dto;
    }
}
