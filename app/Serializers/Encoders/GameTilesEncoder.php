<?php declare(strict_types=1);

namespace App\Serializers\Encoders;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * The "GameTilesEncoder" class
 */
class GameTilesEncoder implements EncoderInterface, DecoderInterface
{
    const FORMAT = 'game_tiles';

    /**
     * @inheritDoc
     */
    public function decode(string $data, string $format, array $context = [])
    {
        $data = array_map('intval', str_split($data, 2));

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supportsDecoding(string $format)
    {
        return $format === static::FORMAT;
    }

    /**
     * @inheritDoc
     */
    public function encode($data, string $format, array $context = [])
    {
        return implode('', $data);
    }

    /**
     * @inheritDoc
     */
    public function supportsEncoding(string $format)
    {
        return $format === static::FORMAT;
    }
}
