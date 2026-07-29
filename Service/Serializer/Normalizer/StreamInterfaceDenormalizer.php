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

use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Params untyped to stay loadable on symfony/serializer 4.x, whose interfaces are untyped.
 */
class StreamInterfaceDenormalizer implements DenormalizerInterface, NormalizerInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function denormalize($data, $type, $format = null, array $context = []): ?StreamInterface
    {
        if (null === $data) {
            return null;
        }

        if (!$data instanceof StreamInterface) {
            throw new NotNormalizableValueException(sprintf(
                'Expected an instance of "%s", "%s" given.',
                StreamInterface::class,
                is_object($data) ? get_class($data) : gettype($data)
            ));
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return is_a($type, StreamInterface::class, true);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<mixed>
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        throw new LogicException(sprintf(
            'Cannot normalize "%s" to format "%s": streams cannot be embedded in a serialized'
            . ' request body, use EndpointInterface::FORMAT_MULTIPART ("%s") as the request format.',
            get_class($object),
            $format ?? 'null',
            EndpointInterface::FORMAT_MULTIPART
        ));
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof StreamInterface;
    }

    /**
     * Concrete implementations still match the StreamInterface entry (the serializer checks
     * is_subclass_of() for object-shaped types), so `true` is a safe cacheable answer.
     *
     * @return array<string, bool|null>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [StreamInterface::class => true];
    }
}
