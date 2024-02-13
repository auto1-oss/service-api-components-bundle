<?php

namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Endpoint;

use PHPUnit\Framework\TestCase;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointsConfigurationLoader;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Class EndpointsConfigurationLoaderTest
 */
class EndpointsConfigurationLoaderTest extends TestCase
{
    use ProphecyTrait;

    public function testConstructor(): void
    {
        $endpointsConfigurationLoader = new EndpointsConfigurationLoader('configFilePathString');
        self::assertInstanceOf(EndpointsConfigurationLoader::class, $endpointsConfigurationLoader);
    }
}
