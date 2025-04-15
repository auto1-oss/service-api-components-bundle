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
use Auto1\ServiceAPIComponentsBundle\Service\Logger\LoggerAwareTrait;

/**
 * Class EndpointFactory
 */
class EndpointFactory implements EndpointFactoryInterface
{
    use LoggerAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @throws ConfigurationException
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
    ): EndpointInterface
    {
        $endpoint = new Endpoint();
        $this->setEndpointMethod($endpoint, $method);
        $this->setEndpointBaseUrl($endpoint, $baseUrl);
        $this->setEndpointPath($endpoint, $path);
        $this->setEndpointRequestClass($endpoint, $requestClass);
        $this->setEndpointResponseClass($endpoint, $responseClass);
        $this->setEndpointRequestFormat($endpoint, $requestFormat);
        $this->setEndpointResponseFormat($endpoint, $responseFormat);
        $this->setEndpointDateTimeFormat($endpoint, $dateTimeFormat);

        return $endpoint;
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $method
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointMethod(Endpoint $endpoint, string $method): EndpointInterface
    {
        if (!in_array($method, self::SUPPORTED_METHODS)) {
            $errorMessage = 'Endpoint method not supported';
            $this->getLogger()->error($errorMessage, [
                'method' => $method,
            ]);
            throw new ConfigurationException($errorMessage);
        }

        return $endpoint->setMethod($method);
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $baseUrl
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointBaseUrl(Endpoint $endpoint, string $baseUrl = null): EndpointInterface
    {
        if (null === $baseUrl) {
            return $endpoint;
        }

        return $endpoint->setBaseUrl($baseUrl);
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $path
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointPath(Endpoint $endpoint, string $path): EndpointInterface
    {
        if (!preg_match('/^\/.*/', $path, $matches)) {
            $errorMessage = 'Invalid Endpoint path';
            $this->getLogger()->error($errorMessage, [
                'path' => $path,
            ]);
            throw new ConfigurationException($errorMessage);
        }

        return $endpoint->setPath($path);
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $requestClass
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointRequestClass(Endpoint $endpoint, string $requestClass): EndpointInterface
    {
        $requestClass = ltrim($requestClass, '\\');

        return $endpoint->setRequestClass($requestClass);
    }

    /**
     * @param Endpoint    $endpoint
     * @param string|null $responseClass
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointResponseClass(Endpoint $endpoint, $responseClass = null): EndpointInterface
    {
        if (null === $responseClass) {
            return $endpoint;
        }

        $className = $responseClass;
        if (preg_match('/.*\[\]$/', $className)) {
            $className = substr($className, 0, -2);
        }
        if (!class_exists($className)) {
            $errorMessage = 'Invalid Endpoint responseClass';
            $this->getLogger()->error($errorMessage, [
                'responseClass' => $responseClass,
            ]);
            throw new ConfigurationException($errorMessage);
        }

        return $endpoint->setResponseClass($responseClass);
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $format
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointRequestFormat(Endpoint $endpoint, string $format): EndpointInterface
    {
        return $endpoint->setRequestFormat($format);
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $format
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointResponseFormat(Endpoint $endpoint, string $format): EndpointInterface
    {
        return $endpoint->setResponseFormat($format);
    }

    /**
     * @param Endpoint $endpoint
     * @param string   $format
     *
     * @return EndpointInterface
     *
     * @throws ConfigurationException
     */
    private function setEndpointDateTimeFormat(Endpoint $endpoint, $format = null): EndpointInterface
    {
        return $endpoint->setDateTimeFormat($format);
    }
}
