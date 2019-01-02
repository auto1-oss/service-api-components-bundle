<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\UrlResolver;

use Auto1\ServiceAPIComponentsBundle\Service\Logger\LoggerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ParameterAwareUrlResolver
 *
 * Will resolve base url if it is set in container as variable parameter.
 */
class ParameterAwareUrlResolver implements UrlResolverInterface
{
    use LoggerAwareTrait;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(string $baseUrl): string
    {
        if (preg_match('/^%(.*)%$/', $baseUrl, $matches)) {
            if (!isset($matches[1])) {
                $errorMessage = 'Endpoint BaseUrl configuration not found';
                $this->getLogger()->error($errorMessage, [
                    'baseUrl' => $baseUrl,
                ]);

                return $baseUrl;
            }

            if (!$this->container->hasParameter($matches[1])) {
                $errorMessage = 'Parameter not found for Endpoint BaseUrl configuration';
                $this->getLogger()->error($errorMessage, [
                    'parameter' => $matches[1],
                ]);

                return $baseUrl;
            }

            $baseUrl = $this->container->getParameter($matches[1]);
        }

        return $baseUrl;
    }
}
