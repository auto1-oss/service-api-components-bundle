<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle;

use Auto1\ServiceAPIComponentsBundle\DependencyInjection\CompilerPass\EndpointProviderCompilerPass;
use Auto1\ServiceAPIComponentsBundle\DependencyInjection\CompilerPass\UrlResolverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class Auto1ServiceAPIComponentsBundle
 */
class Auto1ServiceAPIComponentsBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new UrlResolverCompilerPass());
        $container->addCompilerPass(new EndpointProviderCompilerPass());
    }
}
