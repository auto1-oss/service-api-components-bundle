<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Implementation of LoggerAwareTrait.
 */
trait LoggerAwareTrait
{
    /**
     * @var LoggerInterface
     */
    private $traitLogger;

    /**
     * @return LoggerInterface
     */
    protected function getLogger() : LoggerInterface
    {
        return $this->traitLogger ?? new NullLogger();
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->traitLogger = $logger;

        return $this;
    }
}
