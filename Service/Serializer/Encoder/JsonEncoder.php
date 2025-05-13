<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder;

/**
 * Class JsonEncoder
 */
class JsonEncoder extends \Symfony\Component\Serializer\Encoder\JsonEncoder
{
    const FORMAT_JSON_PATCH = 'json-patch';

    public function supportsEncoding($format): bool
    {
        return static::FORMAT_JSON_PATCH === $format || parent::supportsEncoding($format);
    }

    public function supportsDecoding($format): bool
    {
        return static::FORMAT_JSON_PATCH === $format || parent::supportsDecoding($format);
    }
}
