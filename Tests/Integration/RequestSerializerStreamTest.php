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

namespace Auto1\ServiceAPIComponentsBundle\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Boots the real `auto1.api.request.serializer` from Resources/config/symfony_services.yml,
 * rather than a hand-wired Serializer, so that a regression in the normalizer wiring
 * (dropping or reordering ArrayDenormalizer / StreamInterfaceDenormalizer) fails the build
 * instead of silently breaking multipart file uploads.
 *
 * Framework-provided services that the serializer graph depends on but that the stream path
 * never invokes (object normalizer collaborators) are stubbed, so no FrameworkBundle is needed.
 */
class RequestSerializerStreamTest extends TestCase
{
    private const CONFIG_FILE = 'symfony_services.yml';

    private const SERVICE_REQUEST_SERIALIZER = 'auto1.api.request.serializer';
    private const SERVICE_JSON_ENCODER_PARENT = 'serializer.encoder.json';

    /**
     * Framework service id => interface used both as the synthetic definition class and the mock type.
     */
    private const STUBBED_FRAMEWORK_SERVICES = [
        'serializer.mapping.class_metadata_factory' => ClassMetadataFactoryInterface::class,
        'serializer.name_converter.metadata_aware' => NameConverterInterface::class,
        'serializer.property_accessor' => PropertyAccessorInterface::class,
        'property_info' => PropertyInfoExtractorInterface::class,
    ];

    private function buildRequestSerializer(): DenormalizerInterface
    {
        $container = new ContainerBuilder();

        // Real parent for `auto1.api.encoder.json`; constructible with no required arguments.
        $container->register(self::SERVICE_JSON_ENCODER_PARENT, JsonEncoder::class);

        foreach (self::STUBBED_FRAMEWORK_SERVICES as $id => $interface) {
            $container
                ->register($id, $interface)
                ->setSynthetic(true)
            ;
        }

        $locator = new FileLocator(__DIR__ . '/../../Resources/config');
        $loader = new YamlFileLoader($container, $locator);
        $loader->load(self::CONFIG_FILE);

        $container
            ->getDefinition(self::SERVICE_REQUEST_SERIALIZER)
            ->setPublic(true)
        ;
        $container->compile();

        foreach (self::STUBBED_FRAMEWORK_SERVICES as $id => $interface) {
            $container->set($id, $this->createMock($interface));
        }

        return $container->get(self::SERVICE_REQUEST_SERIALIZER);
    }

    public function testRequestSerializerPassesASingleStreamThrough(): void
    {
        $serializer = $this->buildRequestSerializer();
        $stream = $this->createMock(StreamInterface::class);

        $result = $serializer->denormalize($stream, StreamInterface::class);

        self::assertSame($stream, $result);
    }

    /**
     * The realistic `files[]` shape: a DTO property typed `StreamInterface[]`. ArrayDenormalizer
     * must iterate the collection and hand each element to StreamInterfaceDenormalizer untouched.
     */
    public function testRequestSerializerPassesACollectionOfStreamsThrough(): void
    {
        $serializer = $this->buildRequestSerializer();

        $firstStream = $this->createMock(StreamInterface::class);
        $secondStream = $this->createMock(StreamInterface::class);

        $result = $serializer->denormalize(
            [$firstStream, $secondStream],
            StreamInterface::class . '[]'
        );

        self::assertSame([$firstStream, $secondStream], $result);
    }
}
