<?php

/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
declare(strict_types=1);

namespace Auto1\ServiceAPIComponentsBundle\Service\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Implementation of LoggerAwareTrait.
 */
trait LoggerAwareTrait
{
    /**
     * @var LoggerInterface|null
     */
    private $traitLogger;

    /**
     * @return LoggerInterface
     */
    protected function getLogger(): LoggerInterface
    {
        return $this->traitLogger ?? new NullLogger();
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->traitLogger = $logger;
    }
}
