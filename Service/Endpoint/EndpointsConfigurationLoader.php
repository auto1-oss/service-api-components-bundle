<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

use Symfony\Component\Yaml\Yaml;

class EndpointsConfigurationLoader implements EndpointsConfigurationLoaderInterface
{
    /**
     * @var string
     */
    private $configFilePath;

    /**
     * EndpointsConfigurationLoader constructor.
     *
     * @param string $configFilePath
     */
    public function __construct(
        string $configFilePath
    ) {
        $this->configFilePath = $configFilePath;
    }

    /**
     * @inheritdoc
     */
    public function load(): array
    {
        return Yaml::parse(file_get_contents($this->configFilePath));
    }
}
