<?php
declare(strict_types=1);

namespace Auto1\ServiceAPIComponentsBundle\Service\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class HyphenToUnderscoreNameConverterDecorator implements NameConverterInterface
{
    /** @var NameConverterInterface */
    private $nameConverter;

    /**
     * HyphenToUnderscoreNameConverterDecorator constructor.
     * @param NameConverterInterface $nameConverter
     */
    public function __construct(NameConverterInterface $nameConverter)
    {
        $this->nameConverter = $nameConverter;
    }

    /**
     * {@inheritDoc}
     */
    public function normalize($propertyName)
    {
        return $this->nameConverter->normalize($propertyName);
    }

    /**
     * {@inheritDoc}
     */
    public function denormalize($propertyName)
    {
        return $this->nameConverter->denormalize(\str_replace('-', '_', $propertyName));
    }
}
