<?php declare(strict_types=1);

namespace App\Strategies;

use App\Dto\GameTilesDto;
use App\Services\TilesValidatorService;

/**
 * The "RandomTilesStrategy" class
 */
class RandomTilesStrategy implements TilesStrategyInterface
{
    /**
     * @var TilesValidatorService
     */
    private TilesValidatorService $tilesValidatorService;

    public function __construct(TilesValidatorService $tilesValidatorService)
    {
        $this->tilesValidatorService = $tilesValidatorService;
    }

    /**
     * @inheritDoc
     */
    public function dto(string $tiles): GameTilesDto
    {
        do {
            $range = range(1, 15);
            shuffle($range);
            $range[] = 0;
        } while ($this->tilesValidatorService->isValid($range));

        return new GameTilesDto(...$range);
    }
}
