<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\UrlResolver;

interface UrlResolverInterface
{
    /**
     * @param string $baseUrl
     * @return string
     */
    public function resolve(string $baseUrl): string;
}
