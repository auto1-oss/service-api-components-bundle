<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

/**
 * Interface EndpointFactoryInterface
 */
interface EndpointFactoryInterface
{
    const SUPPORTED_METHODS = [
        EndpointInterface::METHOD_GET,
        EndpointInterface::METHOD_POST,
        EndpointInterface::METHOD_PATCH,
        EndpointInterface::METHOD_PUT,
        EndpointInterface::METHOD_DELETE,
        EndpointInterface::METHOD_HEAD,
    ];

    /**
     * @param string $method
     * @param string|null $baseUrl
     * @param string $path
     * @param string $requestFormat
     * @param string $requestClass
     * @param string $responseFormat
     * @param string|null $responseClass
     * @param string|null $dateTimeFormat
     *
     * @return EndpointInterface
     */
    public function createEndpoint(
        string $method,
        $baseUrl,
        string $path,
        string $requestFormat,
        string $requestClass,
        string $responseFormat,
        $responseClass = null,
        $dateTimeFormat = null
    ) : EndpointInterface;
}
