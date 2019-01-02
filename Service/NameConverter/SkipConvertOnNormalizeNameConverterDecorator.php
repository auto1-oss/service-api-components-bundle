<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Class SkipConvertOnNormalizeNameConverterDecorator
 *
 * TODO: extend implementation and make it configurable
 */
class SkipConvertOnNormalizeNameConverterDecorator implements NameConverterInterface
{
    /**
     * @var NameConverterInterface
     */
    private $nameConverter;

    /**
     * SnakeCaseToCamelCaseOnDenormalizeDecoratorNameConverter constructor.
     *
     * @param NameConverterInterface $nameConverter
     */
    public function __construct(NameConverterInterface $nameConverter)
    {
        $this->nameConverter = $nameConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($propertyName)
    {
        return $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($propertyName)
    {
        return $this->nameConverter->denormalize($propertyName);
    }
}
