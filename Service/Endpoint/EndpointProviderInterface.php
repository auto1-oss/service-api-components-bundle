<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

/**
 * Interface EndpointProviderInterface
 */
interface EndpointProviderInterface
{
    /**
     * @return EndpointInterface[]
     */
    public function getEndpoints(): array;
}
