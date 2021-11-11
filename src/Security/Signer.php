<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

interface Signer
{
    /**
     * @param mixed $subject
     * @param \DateInterval|null $ttl
     * @return \Dynata\Rex\Security\Signature
     */
    public function sign($subject, \DateInterval $ttl = null): Signature;
}
