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

namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ArrayAccessNormalizer implements DenormalizerInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function denormalize($data, $class, $format = null, array $context = []): object
    {
        $object = new $class();

        foreach ($data as $key => $value) {
            $object->offsetSet($key, $value);
        }

        return $object;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        if (!class_exists($type)) {
            return false;
        }

        $reflectionClass = new \ReflectionClass($type);

        if ($reflectionClass->implementsInterface(\ArrayAccess::class)) {
            return true;
        }

        return false;
    }

    /**
     * @return array<string, bool|null>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [\ArrayAccess::class => false];
    }
}
