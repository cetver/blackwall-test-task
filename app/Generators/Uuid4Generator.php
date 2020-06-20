<?php declare(strict_types=1);

namespace App\Generators;

use Ramsey\Uuid\Uuid;

/**
 * The "Uuid4Generator" class
 */
class Uuid4Generator implements Uuid4GeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
