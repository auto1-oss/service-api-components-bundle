<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

/**
 * Interface EndpointsConfigurationLoaderInterface
 */
interface EndpointsConfigurationLoaderInterface
{
    /**
     * @return array
     */
    public function load(): array;
}
