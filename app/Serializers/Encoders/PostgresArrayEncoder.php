<?php declare(strict_types=1);

namespace App\Serializers\Encoders;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * The "PostgresArrayEncoder" class
 */
class PostgresArrayEncoder implements EncoderInterface, DecoderInterface
{
    const FORMAT = 'postgres_array';

    /**
     * @inheritDoc
     */
    public function decode(string $data, string $format, array $context = [])
    {
        return json_decode(
            str_replace(
                ['{', '}'],
                ['[', ']'],
                $data
            )
        );
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
        return str_replace(
            ['[', ']'],
            ['{', '}'],
            json_encode($data)
        );
    }

    /**
     * @inheritDoc
     */
    public function supportsEncoding(string $format)
    {
        return $format === static::FORMAT;
    }
}
