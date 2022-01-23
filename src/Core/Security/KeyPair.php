<?php

declare(strict_types=1);

namespace Dynata\Rex\Core\Security;

class KeyPair
{
    public string $accessKey;
    public string $secretKey;

    public function __construct(string $accessKey, string $secretKey)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }
}
