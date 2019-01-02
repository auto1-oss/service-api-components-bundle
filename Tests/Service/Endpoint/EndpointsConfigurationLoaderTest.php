<?php

namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Endpoint;

use PHPUnit\Framework\TestCase;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointsConfigurationLoader;

/**
 * Class EndpointsConfigurationLoaderTest
 */
class EndpointsConfigurationLoaderTest extends TestCase
{
    public function testConstructor()
    {
        $endpointsConfigurationLoader = new EndpointsConfigurationLoader('configFilePathString');
        self::assertInstanceOf(EndpointsConfigurationLoader::class, $endpointsConfigurationLoader);
    }
}