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
    public function encode($data, $format, array $context = array())
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format)
    {
        return self::FORMAT === $format;
    }
}
