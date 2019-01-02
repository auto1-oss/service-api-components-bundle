<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\UrlResolver;

use Auto1\ServiceAPIComponentsBundle\Exception\Core\ConfigurationException;
use Auto1\ServiceAPIComponentsBundle\Service\Logger\LoggerAwareTrait;

/**
 * Class ChainUrlResolver
 */
class ChainUrlResolver implements UrlResolverInterface
{
    use LoggerAwareTrait;

    private const BASE_URL_WAS_NOT_RESOLVED = 'Base URL was not resolved';

    /**
     * @var UrlResolverInterface[]
     */
    private $resolvers;

    /**
     * @param UrlResolverInterface $resolver
     *
     * @return self
     */
    public function registerResolver(UrlResolverInterface $resolver): self
    {
        $this->resolvers[] = $resolver;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConfigurationException
     */
    public function resolve(string $baseUrl): string
    {
        foreach ($this->resolvers as $resolver) {
            $baseUrl = $resolver->resolve($baseUrl);
            if ($this->isResolved($baseUrl)) {
                return $baseUrl;
            }
        }

        throw new ConfigurationException(self::BASE_URL_WAS_NOT_RESOLVED);
    }

    /**
     * @param string $baseUrl
     *
     * @return bool
     */
    private function isResolved(string $baseUrl): bool
    {
        return !empty(parse_url($baseUrl, PHP_URL_HOST));
    }
}
