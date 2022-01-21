<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

class BasicCredentialsProvider implements CredentialsProvider
{
    private KeyPair $keys;

    public function __construct(string $accessKey, string $secretKey)
    {
        $this->keys = new KeyPair($accessKey, $secretKey);
    }

    public function getCredentials(): KeyPair
    {
        return $this->keys;
    }
}
