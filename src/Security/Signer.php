<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

interface Signer
{
    public function sign($subject, \DateInterval $ttl = null): Signature;
}
