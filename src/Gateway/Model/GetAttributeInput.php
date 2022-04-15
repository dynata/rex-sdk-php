<?php

namespace Dynata\Rex\Gateway\Model;

class GetAttributeInput
{
    public ?int $page_number;
    public ?int $page_size;
    public ?bool $prime;
    public ?string $country;
}
