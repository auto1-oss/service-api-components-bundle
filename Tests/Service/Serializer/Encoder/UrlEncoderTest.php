<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Serializer\Encoder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder\UrlEncoder;

class UrlEncoderTest extends TestCase
{
    /**
     * @var UrlEncoder
     */
    private $encoder;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->encoder = new UrlEncoder();
        $this->serializer = new Serializer(array(new CustomNormalizer()), array('url' => new UrlEncoder()));
    }

    public function testEncodeSimple(): void
    {
        $obj = new \stdClass();
        $obj->foo = 'foo';

        $expected = 'foo=foo';

        self::assertEquals($expected, $this->encoder->encode($obj, 'url'));
    }

    public function testEncodeCamelToSnakeCaseNames(): void
    {
        $obj = $this->getObject();

        $expected = $this->getUrlSource();

        self::assertEquals($expected, $this->encoder->encode($obj, 'url'));
    }

    /**
     * @return string
     */
    protected function getUrlSource(): string
    {
        return 'foo=foo&foo_bar=fooBar';
    }

    /**
     * @return \stdClass
     */
    protected function getObject(): \stdClass
    {
        $obj = new \stdClass();
        $obj->foo = 'foo';
        $obj->fooBar = 'fooBar';

        return $obj;
    }
}
