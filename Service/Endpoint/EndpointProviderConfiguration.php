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

use Auto1\ServiceAPIComponentsBundle\Exception\Core\ConfigurationException;

/**
 * Class EndpointProviderConfiguration
 */
class EndpointProviderConfiguration implements EndpointProviderInterface
{
    const METHODS_WITHOUT_BODY = [
        EndpointInterface::METHOD_GET,
    ];

    const DEFAULT_FORMAT = EndpointInterface::FORMAT_JSON;
    const VOID_FORMAT = 'void';

    /**
     * @var EndpointFactoryInterface
     */
    private $endpointFactory;

    /**
     * @var EndpointsConfigurationLoaderInterface
     */
    private $configurationLoader;

    /**
     * EndpointProviderConfiguration constructor.
     * @param EndpointFactoryInterface $endpointFactory
     * @param EndpointsConfigurationLoaderInterface $configurationLoader
     */
    public function __construct(
        EndpointFactoryInterface $endpointFactory,
        EndpointsConfigurationLoaderInterface $configurationLoader
    ) {
        $this->endpointFactory = $endpointFactory;
        $this->configurationLoader = $configurationLoader;
    }

    /**
     * @return EndpointInterface[]
     *
     * @throws ConfigurationException
     */
    public function getEndpoints(): array
    {
        $endpointCollection = [];

        $endpointConfigurations = $this->configurationLoader->load();
        foreach ($endpointConfigurations as $endpointConfiguration) {
            $this->checkEndpointConfiguration($endpointConfiguration);
            $method = $endpointConfiguration['method'];
            $baseUrl = $endpointConfiguration['baseUrl'] ?? null;
            $path = $endpointConfiguration['path'];
            $requestClass = $endpointConfiguration['requestClass'];
            $errorClass = $endpointConfiguration['errorClass'] ?? null;
            $responseClass = $endpointConfiguration['responseClass'] ?? null;
            $requestFormat = $endpointConfiguration['requestFormat']
                ?? (\in_array($method, self::METHODS_WITHOUT_BODY)
                    ? self::VOID_FORMAT
                    : self::DEFAULT_FORMAT
                );
            $responseFormat = $endpointConfiguration['responseFormat'] ?? self::DEFAULT_FORMAT;
            $dateTimeFormat = $endpointConfiguration['dateTimeFormat'] ?? null;

            $endpoint = $this->endpointFactory->createEndpoint(
                $method,
                $baseUrl,
                $path,
                $requestFormat,
                $requestClass,
                $responseFormat,
                $responseClass,
                $dateTimeFormat,
                $errorClass
            );

            $endpointCollection[] = $endpoint;
        }

        return $endpointCollection;
    }

    /**
     * @param array $endpointConfiguration
     *
     * @throws ConfigurationException
     */
    private function checkEndpointConfiguration(array $endpointConfiguration)
    {
        if (!array_key_exists('requestClass', $endpointConfiguration)) {
            $errorMessage = 'Endpoint requestClass not set';

            throw new ConfigurationException($errorMessage);
        }
        $requestClass = $endpointConfiguration['requestClass'];
        if (!array_key_exists('method', $endpointConfiguration)) {
            $errorMessage = sprintf('Endpoint method not set for: %s', $requestClass);

            throw new ConfigurationException($errorMessage);
        }
        if (!array_key_exists('path', $endpointConfiguration)) {
            $errorMessage = sprintf('Endpoint path not set for: %s', $requestClass);

            throw new ConfigurationException($errorMessage);
        }
    }
}
