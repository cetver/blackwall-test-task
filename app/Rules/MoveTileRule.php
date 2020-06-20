<?php declare(strict_types=1);

namespace App\Rules;

use App\Dto\GameTilesDto;
use App\Serializers\Encoders\GameTilesEncoder;
use App\Services\TilesValidatorService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MoveTileRule implements Rule
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var TilesValidatorService
     */
    private TilesValidatorService $tilesValidatorService;
    /**
     * @var Request
     */
    private Request $request;

    public function __construct(TilesValidatorService $tilesValidatorService)
    {
        $this->tilesValidatorService = $tilesValidatorService;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $moves = $value;
        $lastMoveIndex = array_key_last($moves);
        $lastMove = $value[$lastMoveIndex];
        unset($moves[$lastMoveIndex]);
        if (!$this->validateLastMove($lastMove)) {
            return false;
        }

        foreach ($moves as $tiles) {
            if (!$this->tilesValidatorService->isValid($tiles)) {
                return false;
            }
        }

        return true;
//        $value .= '00';
//        $dto = $this->serializer->deserialize($value, GameTilesDto::class, GameTilesEncoder::FORMAT);
//        $tiles = $dto->getTiles();
//
//        return $this->tilesValidatorService->isValid($tiles);
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Is not solvable.';
    }

    private function validateLastMove(array $move)
    {
        $validMove = range(1, 15);
        $validMove[] = 0;

        return $validMove === $move;
    }
}
