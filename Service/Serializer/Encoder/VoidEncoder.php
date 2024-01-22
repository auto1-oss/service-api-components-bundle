<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Class VoidEncoder
 */
class VoidEncoder implements EncoderInterface
{
    const FORMAT = 'void';

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format, array $context = array()): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format): bool
    {
        return self::FORMAT === $format;
    }
}
