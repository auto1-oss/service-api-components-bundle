<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

/**
 * Class Endpoint
 */
class Endpoint implements EndpointInterface
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
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     *
     * @return $this
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestClass(): string
    {
        return $this->requestClass;
    }

    /**
     * @param string $requestClass
     *
     * @return $this
     */
    public function setRequestClass(string $requestClass): self
    {
        $this->requestClass = $requestClass;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getResponseClass()
    {
        return $this->responseClass;
    }

    /**
     * @param string $responseClass
     *
     * @return $this
     */
    public function setResponseClass(string $responseClass): self
    {
        $this->responseClass = $responseClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestFormat(): string
    {
        return $this->requestFormat;
    }

    /**
     * @param string $requestFormat
     *
     * @return $this
     */
    public function setRequestFormat(string $requestFormat): self
    {
        $this->requestFormat = $requestFormat;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseFormat(): string
    {
        return $this->responseFormat;
    }

    /**
     * @param string $responseFormat
     *
     * @return $this
     */
    public function setResponseFormat(string $responseFormat): self
    {
        $this->responseFormat = $responseFormat;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    /**
     * @param null|string $dateTimeFormat
     *
     * @return self
     */
    public function setDateTimeFormat($dateTimeFormat): self
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }
}
