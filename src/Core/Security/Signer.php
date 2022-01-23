<?php

declare(strict_types=1);

namespace Dynata\Rex\Core\Security;

interface Signer
{
    /**
     * @param mixed $subject
     * @param \DateInterval|null $ttl
     * @return \Dynata\Rex\Security\Signature
     */
    public function sign($subject, \DateInterval $ttl = null): Signature;
}
