<?php declare(strict_types=1);

namespace App\Serializers\Normalizers;

use App\Dto\GameTilesDto;
use App\Serializers\Encoders\GameTilesEncoder;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

/**
 * The "GameTilesNormalizer" class
 */
class GameTilesNormalizer implements ContextAwareDenormalizerInterface
{
    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        return $type === GameTilesDto::class && $format === GameTilesEncoder::FORMAT;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new GameTilesDto(...$data);
    }
}
