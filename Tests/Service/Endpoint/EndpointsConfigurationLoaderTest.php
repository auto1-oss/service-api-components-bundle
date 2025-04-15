<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Endpoint;

use PHPUnit\Framework\TestCase;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointsConfigurationLoader;

/**
 * Class EndpointsConfigurationLoaderTest
 */
class EndpointsConfigurationLoaderTest extends TestCase
{
    public function testConstructor(): void
    {
        $endpointsConfigurationLoader = new EndpointsConfigurationLoader('configFilePathString');
        self::assertInstanceOf(EndpointsConfigurationLoader::class, $endpointsConfigurationLoader);
    }
}
