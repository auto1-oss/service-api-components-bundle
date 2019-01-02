<?php

namespace Auto1\ServiceAPIComponentsBundle\DependencyInjection\CompilerPass;

use Auto1\ServiceAPIComponentsBundle\Exception\Core\ConfigurationException;
use Auto1\ServiceAPIComponentsBundle\Service\UrlResolver\UrlResolverInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class UrlResolverCompilerPass
 */
class UrlResolverCompilerPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    const RESOLVER_TAG_NAME = 'auto1.api.url_resolver';
    const METHOD_REGISTER_RESOLVER = 'registerResolver';
    const SERVICE_CHAIN_RESOLVER = 'auto1.api.url_resolver';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $chainResolverDefinition = $container->getDefinition(self::SERVICE_CHAIN_RESOLVER);

        /** @var Reference $resolver */
        foreach ($this->findAndSortTaggedServices(self::RESOLVER_TAG_NAME, $container) as $resolver) {
            $definition = $container->getDefinition((string) $resolver);
            if (!is_a($definition->getClass(), UrlResolverInterface::class, true)) {
                throw new ConfigurationException(
                    sprintf('%s should be instance of %s', self::RESOLVER_TAG_NAME, UrlResolverInterface::class)
                );
            }

            $chainResolverDefinition->addMethodCall(self::METHOD_REGISTER_RESOLVER, [$resolver]);
        }
    }
}
