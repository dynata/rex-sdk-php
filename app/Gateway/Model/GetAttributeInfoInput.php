<?php

namespace Dynata\Rex\Gateway\Model;

class GetAttributeInfoInput
{
    public int $attribute_id;

    public function __construct(int $attribute_id)
    {
        $this->attribute_id = $attribute_id;
    }
}
