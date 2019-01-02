<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder;

/**
 * Class JsonEncoder
 */
class JsonEncoder extends \Symfony\Component\Serializer\Encoder\JsonEncoder
{
    const FORMAT_JSON_PATCH = 'json-patch';

    public function supportsEncoding($format)
    {
        return static::FORMAT_JSON_PATCH === $format || parent::supportsEncoding($format);
    }

    public function supportsDecoding($format)
    {
        return static::FORMAT_JSON_PATCH === $format || parent::supportsDecoding($format);
    }
}
