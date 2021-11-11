<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

class Timestamp
{
    private \DateTimeInterface $instant;

    private function __construct(\DateTimeInterface $instant)
    {
        $this->instant = $instant;
    }

    public static function now(): Timestamp
    {
        return Timestamp::fromDateTime(new \DateTimeImmutable());
    }

    public static function fromDateTime(\DateTimeInterface $instant): Timestamp
    {
        return new Timestamp($instant);
    }

    public function until(): \DateInterval
    {
        return (new \DateTimeImmutable())->diff($this->instant);
    }

    public function isBefore(Timestamp $timestamp): bool
    {
        return $this->instant < $timestamp->instant;
    }

    public function isAfter(Timestamp $timestamp): bool
    {
        return $this->instant > $timestamp->instant;
    }

    public function toRfc3339(): string
    {
        return $this->instant->format(\DateTimeInterface::RFC3339);
    }
}
