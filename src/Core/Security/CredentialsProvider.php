<?php

declare(strict_types=1);

namespace Dynata\Rex\Core\Security;

interface CredentialsProvider
{
    public function getCredentials(): KeyPair;
}
