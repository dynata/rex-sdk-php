<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway\Model;

class PutRespondentAnswersInput
{
    public string $respondentId;
    public string $country;
    public array $attributes;

    public function __construct(?string $respondentId, ?string $country, array $attributes)
    {
        $this->respondentId = $respondentId;
        $this->country = $country;
        $this->attributes = $attributes;
    }
}
