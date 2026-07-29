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

namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Serializer\Normalizer;

use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointInterface;
use Auto1\ServiceAPIComponentsBundle\Service\Serializer\Normalizer\StreamInterfaceDenormalizer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class StreamInterfaceDenormalizerTest extends TestCase
{
    private function getCut(): StreamInterfaceDenormalizer
    {
        return new StreamInterfaceDenormalizer();
    }

    public function testSupportsDenormalizationForStreamInterface(): void
    {
        $target = $this->getCut();

        $result = $target->supportsDenormalization(null, StreamInterface::class);

        self::assertTrue($result);
    }

    public function testDoesNotSupportOtherTypes(): void
    {
        $targetUnsupportedType = \stdClass::class;

        $target = $this->getCut();

        $result = $target->supportsDenormalization(null, $targetUnsupportedType);

        self::assertFalse($result);
    }

    public function testPassesThroughStreamInstance(): void
    {
        $targetStream = $this->createMock(StreamInterface::class);

        $target = $this->getCut();

        $result = $target->denormalize($targetStream, StreamInterface::class);

        self::assertSame($targetStream, $result);
    }

    public function testReturnsNullForNullData(): void
    {
        $target = $this->getCut();

        $result = $target->denormalize(null, StreamInterface::class);

        self::assertNull($result);
    }

    public function testThrowsForNonStreamData(): void
    {
        $targetNonStreamData = 'not a stream';

        $target = $this->getCut();

        $this->expectException(NotNormalizableValueException::class);
        $target->denormalize($targetNonStreamData, StreamInterface::class);
    }

    public function testSupportsNormalizationForStreamInstance(): void
    {
        $targetStream = $this->createMock(StreamInterface::class);

        $target = $this->getCut();

        $result = $target->supportsNormalization($targetStream);

        self::assertTrue($result);
    }

    public function testDoesNotSupportNormalizationOfOtherData(): void
    {
        $targetNonStreamData = new \stdClass();

        $target = $this->getCut();

        $result = $target->supportsNormalization($targetNonStreamData);

        self::assertFalse($result);
    }

    public function testNormalizeThrowsForStream(): void
    {
        $targetStream = $this->createMock(StreamInterface::class);

        $target = $this->getCut();

        $this->expectException(LogicException::class);
        $target->normalize($targetStream, EndpointInterface::FORMAT_JSON);
    }

    public function testGetSupportedTypesReturnsCacheableStreamInterfaceEntry(): void
    {
        $target = $this->getCut();

        $result = $target->getSupportedTypes(null);

        self::assertSame([StreamInterface::class => true], $result);
    }
}
