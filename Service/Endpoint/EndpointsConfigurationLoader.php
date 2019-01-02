<?php

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
