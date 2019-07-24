<?php
declare(strict_types=1);

namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Serializer\NameConverter;

use Auto1\ServiceAPIComponentsBundle\Service\NameConverter\HyphenToUnderscoreNameConverterDecorator;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class HyphenToUnderscoreNameConverterDecoratorTest extends TestCase
{
    /** @var NameConverterInterface|ObjectProphecy */
    private $decoratedConverterMock;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->decoratedConverterMock = $this->prophesize(NameConverterInterface::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        $this->decoratedConverterMock->checkProphecyMethodsPredictions();
    }

    /**
     * @param string $propertyName
     * @param string $expectedResult
     *
     * @dataProvider denormalizedNamesDataProvider
     */
    public function testDenormalize(string $propertyName, string $expectedResult)
    {
        $this->decoratedConverterMock
            ->denormalize($expectedResult)
            ->willReturn($expectedResult)
            ->shouldBeCalledOnce();

        $converter = $this->getCut();

        $result = $converter->denormalize($propertyName);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @param string $propertyName
     *
     * @dataProvider denormalizedNamesDataProvider
     */
    public function testNormalize(string $propertyName)
    {
        $this->decoratedConverterMock
            ->normalize($propertyName)
            ->willReturn($propertyName)
            ->shouldBeCalledOnce();

        $converter = $this->getCut();

        $result = $converter->normalize($propertyName);

        $this->assertSame($propertyName, $result);
    }

    /**
     * @return array
     */
    public function normalizedNamesDataProvider(): array
    {
        return [
            'empty' => [''],
            'normal' => ['propertyName'],
            'underscore' => ['property_name'],
            'hyphen' => ['property-name'],
        ];
    }

    /**
     * @return array
     */
    public function denormalizedNamesDataProvider(): array
    {
        return [
            'empty' => ['', ''],
            'normal' => ['propertyName', 'propertyName'],
            'underscore' => ['Property_Name', 'Property_Name'],
            'hyphen' => ['Property-Name', 'Property_Name'],
        ];
    }

    private function getCut(): HyphenToUnderscoreNameConverterDecorator
    {
        return new HyphenToUnderscoreNameConverterDecorator($this->decoratedConverterMock->reveal());
    }
}
