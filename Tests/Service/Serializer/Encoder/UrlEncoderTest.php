<?php

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
    protected function setUp()
    {
        $this->encoder = new UrlEncoder();
        $this->serializer = new Serializer(array(new CustomNormalizer()), array('url' => new UrlEncoder()));
    }

    public function testEncodeSimple()
    {
        $obj = new \stdClass();
        $obj->foo = 'foo';

        $expected = 'foo=foo';

        self::assertEquals($expected, $this->encoder->encode($obj, 'url'));
    }

    public function testEncodeCamelToSnakeCaseNames()
    {
        $obj = $this->getObject();

        $expected = $this->getUrlSource();

        self::assertEquals($expected, $this->encoder->encode($obj, 'url'));
    }

    /**
     * @return string
     */
    protected function getUrlSource()
    {
        return 'foo=foo&foo_bar=fooBar';
    }

    /**
     * @return \stdClass
     */
    protected function getObject()
    {
        $obj = new \stdClass();
        $obj->foo = 'foo';
        $obj->fooBar = 'fooBar';

        return $obj;
    }
}
