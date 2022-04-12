<?php

namespace Dynata\Rex\Gateway\Model;

class GetAttributeInput
{
    public ?int $page_number;
    public ?int $page_size;
    public ?bool $prime;
    public ?string $country;

    public function __construct(?int $page_number, ?int $page_size, ?bool $prime, ?string $country)
    {
        $this->page_number = $page_number;
        $this->page_size = $page_size;
        $this->prime = $prime;
        $this->country = $country;
    }
}
