<?php
/*
* This file is part of the auto1-oss/service-api-components-bundle.
*
* (c) AUTO1 Group SE https://www.auto1-group.com
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
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
    public function normalize($propertyName): string
    {
        return $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($propertyName): string
    {
        return $this->nameConverter->denormalize($propertyName);
    }
}
