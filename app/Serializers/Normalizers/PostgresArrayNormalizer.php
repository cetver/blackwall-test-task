<?php declare(strict_types=1);

namespace App\Serializers\Normalizers;

use App\Serializers\Encoders\PostgresArrayEncoder;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

/**
 * The "PostgresArrayNormalizer" class
 */
class PostgresArrayNormalizer implements ContextAwareDenormalizerInterface
{
    const TYPE = 'postgres_array';

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        return $type === static::TYPE && $format === PostgresArrayEncoder::FORMAT;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $data;
    }
}
