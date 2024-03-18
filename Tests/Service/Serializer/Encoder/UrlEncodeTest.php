<?php

namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Serializer\Encoder;

use PHPUnit\Framework\TestCase;
use Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder\UrlEncode;
use Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder\UrlEncoder;

class UrlEncodeTest extends TestCase
{
    /**
     * @var UrlEncode
     */
    private $encode;

    protected function setUp(): void
    {
        $this->encode = new UrlEncode();
    }

    public function testSupportsEncoding(): void
    {
        $this->assertTrue($this->encode->supportsEncoding(UrlEncoder::FORMAT));
        $this->assertFalse($this->encode->supportsEncoding('foobar'));
    }

    /**
     * @dataProvider encodeProvider
     *
     * @param array  $toEncode
     * @param string $expected
     */
    public function testEncode(array $toEncode, string $expected): void
    {
        $this->assertEquals(
            $expected,
            $this->encode->encode($toEncode, UrlEncoder::FORMAT, [])
        );
    }

    /**
     * @return array
     */
    public static function encodeProvider(): array
    {
        return [
            'empty' => [
                '$toEncode' => [],
                '$expected' => '',
            ],
            'simple_argument' => [
                '$toEncode' => ['foo' => 'bar'],
                '$expected' => 'foo=bar',
            ],
            'camel_to_snake' => [
                '$toEncode' => ['fooBar' => 'fooBar'],
                '$expected' => 'foo_bar=fooBar',
            ],
            'array' => [
                '$toEncode' => ['fooBar' => [1, 2]],
                '$expected' => str_replace(['[', ']'], ['%5B', '%5D'], 'foo_bar[0]=1&foo_bar[1]=2'),
            ],
            'recursion' => [
                '$toEncode' => ['fooBar' => ['foo' => [9, 8], 'bar' => [1, 2]]],
                '$expected' => str_replace(
                    ['[', ']'],
                    ['%5B', '%5D'],
                    'foo_bar[foo][0]=9&foo_bar[foo][1]=8&foo_bar[bar][0]=1&foo_bar[bar][1]=2'
                ),
            ],
        ];
    }
}
