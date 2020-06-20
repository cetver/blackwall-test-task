<?php declare(strict_types=1);

namespace App\Providers;

use App\Generators\Uuid4Generator;
use App\Generators\Uuid4GeneratorInterface;
use Illuminate\Support\ServiceProvider;

/**
 * The "Uuid4GeneratorProvider" class
 */
class Uuid4GeneratorProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Uuid4GeneratorInterface::class, Uuid4Generator::class);
    }
}
