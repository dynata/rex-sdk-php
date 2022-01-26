<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway;

class PutRespondentAnswersInput
{
    public string $respondentId;
    public string $country;
    public array $attributes;
}
