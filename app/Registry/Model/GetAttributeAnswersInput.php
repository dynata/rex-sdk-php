<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class GetAttributeAnswersInput
{
    public string $country;

    /**
     * @param string $country
     */
    public function __construct(string $country)
    {
        $this->country = $country;
    }
}
