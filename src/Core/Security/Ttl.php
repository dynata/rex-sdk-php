<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

class Ttl
{
    public Timestamp $expiration;

    private function __construct(Timestamp $expiration)
    {
        $this->expiration = $expiration;
    }

    public static function fromTimestamp(Timestamp $expiration): Ttl
    {
        return new Ttl($expiration);
    }

    public static function fromDateTime(\DateTimeInterface $expiration): Ttl
    {
        return new Ttl(Timestamp::fromDateTime($expiration));
    }

    public static function fromDateInterval(\DateInterval $expiration): Ttl
    {
        return new Ttl(Timestamp::fromDateTime((new \DateTimeImmutable())->add($expiration)));
    }

    public function isExpired(): bool
    {
        return Timestamp::now()->isAfter($this->expiration);
    }

    public function remaining(): \DateInterval
    {
        return $this->expiration->until();
    }
}
