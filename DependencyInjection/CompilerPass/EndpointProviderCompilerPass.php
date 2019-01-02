<?php

namespace Auto1\ServiceAPIComponentsBundle\DependencyInjection\CompilerPass;

use Auto1\ServiceAPIComponentsBundle\Exception\Core\ConfigurationException;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointImmutable;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointInterface;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class EndpointProviderCompilerPass
 */
class EndpointProviderCompilerPass implements CompilerPassInterface
{
    const VISITOR_TAG_NAME = 'auto1.api.endpoint_provider';
    const VISITOR_TAG_KEY_PRIORITY = 'priority';
    const METHOD_REGISTER_ENDPOINT = 'registerEndpoint';
    const SERVICE_ENDPOINT_REGISTRY = 'auto1.api.endpoint.registry';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $endpointRegistryDefinition = $container->getDefinition(self::SERVICE_ENDPOINT_REGISTRY);

        $endpointsToCompile = [];

        foreach ($this->getEndpointProviders($container) as $provider) {
            if (!$provider instanceof EndpointProviderInterface) {
                throw new ConfigurationException(
                    sprintf('%s should be instance of %s', self::VISITOR_TAG_NAME, EndpointProviderInterface::class)
                );
            }

            foreach ($provider->getEndpoints() as $endpoint) {
                if (!$endpoint instanceof EndpointInterface) {
                    throw new ConfigurationException(
                        sprintf(
                            '%s should return instances of %s',
                            EndpointProviderInterface::class,
                            EndpointInterface::class
                        )
                    );
                }

                if (false === class_exists($endpoint->getRequestClass())) {
                    continue;
                }

                $endpointsToCompile[$endpoint->getRequestClass()] = $endpoint;
            }
        }

        foreach ($endpointsToCompile as $endpoint) {
            $endpointRegistryDefinition->addMethodCall(
                self::METHOD_REGISTER_ENDPOINT,
                [$this->createEndpointImmutableDefinition($endpoint)]
            );
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return EndpointProviderInterface[]|\Traversable
     */
    private function getEndpointProviders(ContainerBuilder $container): \Traversable
    {
        $providerIds = $container->findTaggedServiceIds(self::VISITOR_TAG_NAME);

        $providerPriorities = [];
        foreach ($providerIds as $id => $tags) {
            $maxPriority = max(array_column($tags, self::VISITOR_TAG_KEY_PRIORITY));

            $providerPriorities[$id] = $maxPriority;
        }

        asort($providerPriorities);

        $providerIdsPrioritised = array_keys($providerPriorities);

        foreach ($providerIdsPrioritised as $id) {
            yield $container->resolveServices($container->getDefinition($id));
        }
    }

    /**
     * @param EndpointInterface $endpoint
     *
     * @return Definition
     */
    private function createEndpointImmutableDefinition(EndpointInterface $endpoint) : Definition
    {
        return (new Definition(EndpointImmutable::class))->setArguments([
            $endpoint->getMethod(),
            $endpoint->getBaseUrl(),
            $endpoint->getPath(),
            $endpoint->getRequestFormat(),
            $endpoint->getRequestClass(),
            $endpoint->getResponseFormat(),
            $endpoint->getResponseClass(),
            $endpoint->getDateTimeFormat(),
        ]);
    }
}
