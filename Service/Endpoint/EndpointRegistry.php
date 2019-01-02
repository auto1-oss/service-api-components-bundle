<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

use Auto1\ServiceAPIComponentsBundle\Exception\Core\ConfigurationException;
use Auto1\ServiceAPIComponentsBundle\Service\Logger\LoggerAwareTrait;
use Auto1\ServiceAPIComponentsBundle\Service\UrlResolver\UrlResolverInterface;
use Auto1\ServiceAPIRequest\ServiceRequestInterface;

/**
 * Class EndpointRegistry
 */
class EndpointRegistry implements EndpointRegistryInterface
{
    use LoggerAwareTrait;

    /**
     * @var EndpointInterface[]
     */
    private $endpointStorage = [];

    /**
     * @var UrlResolverInterface
     */
    private $urlResolver;

    /**
     * EndpointFactory constructor.
     * @param UrlResolverInterface $urlResolver
     */
    public function __construct(UrlResolverInterface $urlResolver)
    {
        $this->urlResolver = $urlResolver;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConfigurationException
     */
    public function getEndpoint(ServiceRequestInterface $serviceRequest): EndpointInterface
    {
        $id = \get_class($serviceRequest);
        if (false === \array_key_exists($id, $this->endpointStorage)) {
            $errorMessage = 'Endpoint unknown';
            $this->getLogger()->error($errorMessage, [
                'className' => $id,
            ]);

            throw new ConfigurationException($errorMessage);
        }

        $endpoint = $this->endpointStorage[$id];
        $baseUrl = (null === $endpoint->getBaseUrl()) ? null : $this->urlResolver->resolve($endpoint->getBaseUrl());

        if (null !== $baseUrl && empty(parse_url($baseUrl, PHP_URL_HOST))) {
            $errorMessage = 'Invalid Endpoint baseUrl';
            $this->getLogger()->error($errorMessage, [
                'baseUrl' => $baseUrl,
            ]);
            throw new ConfigurationException($errorMessage);
        }

        return new EndpointImmutable(
            $endpoint->getMethod(),
            $baseUrl,
            $endpoint->getPath(),
            $endpoint->getRequestFormat(),
            $endpoint->getRequestClass(),
            $endpoint->getResponseFormat(),
            $endpoint->getResponseClass(),
            $endpoint->getDateTimeFormat()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConfigurationException
     */
    public function registerEndpoint(EndpointInterface $endpoint)
    {
        $id = $endpoint->getRequestClass();

        if (array_key_exists($id, $this->endpointStorage)) {
            $errorMessage = 'Endpoint with such requestClass already registered';
            $this->getLogger()->error($errorMessage, [
                'className' => $id,
            ]);

            throw new ConfigurationException($errorMessage);
        }

        $this->endpointStorage[$id] = $endpoint;
    }
}
