<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Service\Endpoint;

use Fig\Http\Message\RequestMethodInterface;

/**
 * To be implemented in the bridge
 *
 * Interface EndpointInterface
 */
interface EndpointInterface extends RequestMethodInterface
{
    const FORMAT_JSON = 'json';

    /**
     * One of METHOD_* constants
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string|null
     */
    public function getBaseUrl();

    /**
     * @return string|null
     */
    public function getResponseClass();

    /**
     * @return string
     */
    public function getRequestClass(): string;

    /**
     * @return string
     */
    public function getRequestFormat(): string;

    /**
     * @return string
     */
    public function getResponseFormat(): string;

    /**
     * @return string|null
     */
    public function getDateTimeFormat();
}
