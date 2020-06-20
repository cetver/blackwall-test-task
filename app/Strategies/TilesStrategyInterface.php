<?php declare(strict_types=1);

namespace App\Strategies;

use App\Dto\GameTilesDto;

/**
 * The "TilesStrategyInterface" interface
 */
interface TilesStrategyInterface
{
    /**
     * @param string $tiles
     *
     * @return GameTilesDto
     */
    public function dto(string $tiles): GameTilesDto;
}
