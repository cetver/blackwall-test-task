<?php declare(strict_types=1);

namespace App\Caches;

/**
 * The "CachePrefixInterface" interface
 */
interface CachePrefixInterface
{
    /**
     * The separator between {@see cachePrefix()} and a cache key
     */
    public const SEPARATOR = ' - ';

    /**
     * Returns cache prefix, for example, FQCN
     *
     * @return string
     */
    public function cachePrefix(): string;
}
