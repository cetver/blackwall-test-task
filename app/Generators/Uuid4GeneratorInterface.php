<?php declare(strict_types=1);

namespace App\Generators;

/**
 * The "Uuid4GeneratorInterface" interface
 */
interface Uuid4GeneratorInterface
{
    public function generate():string;
}
