<?php declare(strict_types=1);

namespace App\Providers;

use App\Serializers\Encoders\GameTilesEncoder;
use App\Serializers\Encoders\PostgresArrayEncoder;
use App\Serializers\Normalizers\GameTilesCollectionNormalizer;
use App\Serializers\Normalizers\GameTilesNormalizer;
use App\Serializers\Normalizers\PostgresArrayNormalizer;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public array $singletons = [
        GameTilesNormalizer::class => GameTilesNormalizer::class,
        GameTilesEncoder::class => GameTilesEncoder::class,
        PostgresArrayNormalizer::class => PostgresArrayNormalizer::class,
        PostgresArrayEncoder::class => PostgresArrayEncoder::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            Serializer::class,
            function (Application $app) {
                $normalizers = [
                    $app->get(GameTilesNormalizer::class),
                    $app->get(PostgresArrayNormalizer::class),
                ];
                $encoders = [
                    $app->get(GameTilesEncoder::class),
                    $app->get(PostgresArrayEncoder::class),
                ];

                return new Serializer($normalizers, $encoders);
            }
        );
        $this->app->bind(SerializerInterface::class, Serializer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
