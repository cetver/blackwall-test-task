<?php declare(strict_types=1);

namespace App\Services;

/**
 * The "TilesValidatorService" class
 */
class TilesValidatorService
{
    public function isValid(array $tiles): bool
    {
        $countTiles = count($tiles);
        $isValidLength = $countTiles === 16;
        $isValidMinValue = min($tiles) === 0;
        $isValidMaxValue = max($tiles) === 15;
        $isUniqueValues = $countTiles === count(array_unique($tiles));
        $sortedTiles = $tiles;
        asort($sortedTiles);
        $isNotSolved = $sortedTiles !== $tiles;

        return
            $isValidLength &&
            $isValidMinValue &&
            $isValidMaxValue &&
            $isUniqueValues &&
            $isNotSolved &&
            $this->isSolvable($tiles);
    }

    private function isSolvable(array $tiles): bool
    {
        $colNumber = 4;
        $rowNumber = 0;
        $zeroTileRowNumber = 0;
        $zeroTile = 0;
        $inversionCount = 0;
        foreach ($tiles as $i => $tile) {
            if ($i % $colNumber === 0) {
                $rowNumber++;
            }

            if ($tile === $zeroTile) {
                $zeroTileRowNumber = $rowNumber;
                continue;
            }

            for ($j = 0; $j < $i; $j++) {
                $nextTile = $tiles[$j];
                if ($nextTile !== $zeroTile && $tile < $nextTile) {
                    $inversionCount++;
                }
            }
        }

        $isEvenZeroTileRowNumber = ($zeroTileRowNumber % 2 === 0);
        $isEvenInversionCount = ($inversionCount % 2 === 0);

        return ($isEvenZeroTileRowNumber) ? $isEvenInversionCount : !$isEvenInversionCount;
    }
}
