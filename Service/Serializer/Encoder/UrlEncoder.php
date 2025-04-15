<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

class UrlEncoder implements EncoderInterface
{
    const FORMAT = 'url';

    /**
     * @var UrlEncode
     */
    protected $encodingImpl;

    public function __construct(UrlEncode $encodingImpl = null)
    {
        $this->encodingImpl = $encodingImpl ?: new UrlEncode();
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format, array $context = array()): string
    {
        return $this->encodingImpl->encode($data, self::FORMAT, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format): bool
    {
        return self::FORMAT === $format;
    }
}
