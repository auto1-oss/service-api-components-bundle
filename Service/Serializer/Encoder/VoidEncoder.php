<?php

/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
declare(strict_types=1);

namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder;

use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Class VoidEncoder
 */
class VoidEncoder implements EncoderInterface
{
    public const FORMAT = EndpointInterface::FORMAT_VOID;

    /**
     * @param array<string, mixed> $context
     */
    public function encode($data, $format, array $context = []): string
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
