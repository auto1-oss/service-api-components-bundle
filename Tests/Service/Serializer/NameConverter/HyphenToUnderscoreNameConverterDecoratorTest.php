<?php
declare(strict_types=1);

namespace Auto1\ServiceAPIComponentsBundle\Tests\Service\Serializer\NameConverter;

use Auto1\ServiceAPIComponentsBundle\Service\NameConverter\HyphenToUnderscoreNameConverterDecorator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class HyphenToUnderscoreNameConverterDecoratorTest extends TestCase
{
    /** @var NameConverterInterface|MockObject */
    private $decoratedConverterMock;

    protected function setUp()
    {
        $this->decoratedConverterMock = $this->createMock(NameConverterInterface::class);
    }

    public function testConstruct()
    {
        $this->decoratedConverterMock
            ->expects($this->never())
            ->method($this->anything());

        new HyphenToUnderscoreNameConverterDecorator($this->decoratedConverterMock);
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
            ->expects($this->once())
            ->method('denormalize')
            ->with($expectedResult)
            ->willReturn($expectedResult);

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
            ->expects($this->once())
            ->method('normalize')
            ->with($propertyName)
            ->willReturn($propertyName);

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
        return new HyphenToUnderscoreNameConverterDecorator($this->decoratedConverterMock);
    }
}
