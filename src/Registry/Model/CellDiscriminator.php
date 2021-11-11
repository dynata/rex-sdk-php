<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

use Symfony\Component\Serializer\Mapping\ClassDiscriminatorMapping;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;

class CellDiscriminator implements ClassDiscriminatorResolverInterface
{
    private ClassDiscriminatorMapping $cellMapping;

    public function __construct()
    {
        $this->cellMapping = new ClassDiscriminatorMapping('kind', [
            Cell::KIND_VALUE => ValueCell::class,
            Cell::KIND_LIST => ListCell::class,
            Cell::KIND_RANGE => RangeCell::class,
            Cell::KIND_COLLECTION => CollectionCell::class,
        ]);
    }

    public function getMappingForClass(string $class): ?ClassDiscriminatorMapping
    {
        if ($class === Cell::class) {
            return $this->cellMapping;
        } else {
            return null;
        }
    }

    public function getMappingForMappedObject($object): ?ClassDiscriminatorMapping
    {
        if (\is_a($object, Cell::class)) {
            return $this->cellMapping;
        } else {
            return null;
        }
    }

    public function getTypeForMappedObject($object): ?string
    {
        return $this->cellMapping->getMappedObjectType($object);
    }
}
