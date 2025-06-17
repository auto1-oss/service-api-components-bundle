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
