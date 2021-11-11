<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class Cell
{
    const KIND_RANGE = 'RANGE';
    const KIND_LIST = 'LIST';
    const KIND_VALUE = 'VALUE';
    const KIND_COLLECTION = 'COLLECTION';

    public string $tag;
    public int $attributeId;
    public bool $negate;
    /**
     * @var string One of the KIND_* constants
     */
    public string $kind;
}
