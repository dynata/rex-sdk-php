<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway;

class PutRespondentInput
{
    public string $respondentId;
    public string $language;
    public string $country;
    public string $gender;
    public string $birthDate;
    public string $postalCode;
    public ?array $attributes;
}
