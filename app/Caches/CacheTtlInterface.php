<?php declare(strict_types=1);

namespace App\Caches;

/**
 * The "CacheTtlInterface" interface
 */
interface CacheTtlInterface
{
    /**
     * Returns time to live in seconds
     *
     * @return int
     */
    public function cacheTtl(): int;
}
