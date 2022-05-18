<?php

declare(strict_types=1);

namespace Dynata\Rex\Core\Security;

class Signature
{
    public string $expiration;
    public string $accessKey;
    public string $signingString;
    public string $value;

    public function __construct(string $expiration, string $accessKey, string $signingString, string $value)
    {
        $this->expiration = $expiration;
        $this->accessKey = $accessKey;
        $this->signingString = $signingString;
        $this->value = $value;
    }
}
