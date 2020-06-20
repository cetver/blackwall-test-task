<?php declare(strict_types=1);

namespace App\Dto;

/**
 * The "GameTilesDto" class
 */
class GameTilesDto
{
    /**
     * @var int[]
     */
    private array $tiles;

    public function __construct(int ...$tiles)
    {
        $this->tiles = $tiles;
    }

    /**
     * @return int[]
     */
    public function getTiles(): array
    {
        return $this->tiles;
    }
}
