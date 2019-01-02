<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

use Auto1\ServiceAPIRequest\ServiceRequestInterface;

/**
 * Interface EndpointRegistryInterface
 */
interface EndpointRegistryInterface
{
    /**
     * @param EndpointInterface $endpoint
     */
    public function registerEndpoint(EndpointInterface $endpoint);

    /**
     * @param ServiceRequestInterface $serviceRequest
     *
     * @return EndpointInterface
     */
    public function getEndpoint(ServiceRequestInterface $serviceRequest) : EndpointInterface;
}
