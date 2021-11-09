<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

interface CredentialsProvider
{
    public function getCredentials(): KeyPair;
}
