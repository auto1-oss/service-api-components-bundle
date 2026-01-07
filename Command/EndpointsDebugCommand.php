<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Command;

use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointInterface;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointRegistry;
use Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointRegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EndpointsDebugCommand
 */
class EndpointsDebugCommand extends Command
{
    /**
     * @var EndpointRegistryInterface
     */
    private $endpointRegistry;

    /**
     * EndpointsDebugCommand constructor.
     * @param EndpointRegistryInterface $endpointRegistry
     */
    public function __construct(EndpointRegistryInterface $endpointRegistry)
    {
        parent::__construct();

        $this->endpointRegistry = $endpointRegistry;
    }

    protected function configure()
    {
        $this->setName('auto1.debug.endpoints');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reflectionClass = new \ReflectionClass(EndpointRegistry::class);
        $storageProperty = $reflectionClass->getProperty('endpointStorage');
        $storageProperty->setAccessible(true);

        /** @var EndpointInterface[] $endpoints */
        $endpoints = $storageProperty->getValue($this->endpointRegistry);

        foreach ($endpoints as $endpoint) {
            $this->dumpEndpoint($output, $endpoint);
        }

        return 0;
    }

    /**
     * @param OutputInterface $output
     * @param EndpointInterface $endpoint
     */
    private function dumpEndpoint(OutputInterface $output, EndpointInterface$endpoint)
    {
        $output->writeln('-=-=-=-=-=-=-');
        $this->writeConfigLine($output, 'requestClass', $endpoint->getRequestClass());
        $this->writeConfigLine($output, 'baseUrl', $endpoint->getBaseUrl());
        $this->writeConfigLine($output, 'method', $endpoint->getMethod());
        $this->writeConfigLine($output, 'path', $endpoint->getPath());
        $this->writeConfigLine($output, 'requestFormat', $endpoint->getRequestFormat());
        $this->writeConfigLine($output, 'responseClass', $endpoint->getResponseClass());
        $this->writeConfigLine($output, 'errorClass', $endpoint->getErrorClass());
        $this->writeConfigLine($output, 'responseFormat', $endpoint->getResponseFormat());
        $this->writeConfigLine($output, 'dateTimeFormat', $endpoint->getDateTimeFormat());

    }

    /**
     * @param OutputInterface $output
     * @param string $key
     * @param string|null $value
     */
    private function writeConfigLine(OutputInterface $output, string $key, $value)
    {
        $output->writeln(sprintf("<comment>%s</comment> <info>'%s'</info>", str_pad($key.':', 15, ' '), $value ?? '~'));
    }
}
