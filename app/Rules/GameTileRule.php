<?php declare(strict_types=1);

namespace App\Rules;

use App\Dto\GameTilesDto;
use App\Serializers\Encoders\GameTilesEncoder;
use App\Services\TilesValidatorService;
use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\Serializer\SerializerInterface;

class GameTileRule implements Rule
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var TilesValidatorService
     */
    private TilesValidatorService $tilesValidatorService;

    public function __construct(SerializerInterface $serializer, TilesValidatorService $tilesValidatorService)
    {
        $this->serializer = $serializer;
        $this->tilesValidatorService = $tilesValidatorService;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $value .= '00';
        $dto = $this->serializer->deserialize($value, GameTilesDto::class, GameTilesEncoder::FORMAT);
        $tiles = $dto->getTiles();

        return $this->tilesValidatorService->isValid($tiles);
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Invalid tiles.';
    }
}
