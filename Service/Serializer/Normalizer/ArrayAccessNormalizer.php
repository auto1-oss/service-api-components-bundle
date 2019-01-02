<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ArrayAccessNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object = new $class;

        foreach ($data as $key => $value) {
            $object->offsetSet($key, $value);
        }

        return $object;
    }

    public function supportsDenormalization($data, $type, $format = null): bool
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
}
