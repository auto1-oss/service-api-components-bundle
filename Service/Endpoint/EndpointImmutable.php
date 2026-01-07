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

/**
 * Class Endpoint
 */
class EndpointImmutable implements EndpointInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $requestClass;

    /**
     * @var string|null
     */
    private $errorClass;

    /**
     * @var string|null
     */
    private $responseClass;

    /**
     * @var string
     */
    private $requestFormat;

    /**
     * @var string
     */
    private $responseFormat;

    /**
     * @var string|null
     */
    private $dateTimeFormat;

    /**
     * EndpointImmutable constructor.
     *
     * @param string $method
     * @param null|string $baseUrl
     * @param string $path
     * @param string $requestFormat
     * @param string $requestClass
     * @param string $responseFormat
     * @param null|string $responseClass
     * @param null|string $dateTimeFormat
     * @param null|string $errorClass
     */
    public function __construct(
        string $method,
        $baseUrl,
        string $path,
        string $requestFormat,
        string $requestClass,
        string $responseFormat,
        $responseClass = null,
        $dateTimeFormat = null,
        string $errorClass = null
    ) {
        $this->method = $method;
        $this->baseUrl = $baseUrl;
        $this->path = $path;
        $this->requestFormat = $requestFormat;
        $this->requestClass = $requestClass;
        $this->responseFormat = $responseFormat;
        $this->responseClass = $responseClass;
        $this->dateTimeFormat = $dateTimeFormat;
        $this->errorClass = $errorClass;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getRequestClass(): string
    {
        return $this->requestClass;
    }

    /**
     * @return string|null
     */
    public function getResponseClass()
    {
        return $this->responseClass;
    }

    /**
     * @return null|string
     */
    public function getErrorClass()
    {
        return $this->errorClass;
    }

    /**
     * @param string $errorClass
     */
    public function setErrorClass(?string $errorClass): void
    {
        $this->errorClass = $errorClass;
    }

    /**
     * @return string
     */
    public function getRequestFormat(): string
    {
        return $this->requestFormat;
    }

    /**
     * @return string
     */
    public function getResponseFormat(): string
    {
        return $this->responseFormat;
    }

    /**
     * @return null|string
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }
}
