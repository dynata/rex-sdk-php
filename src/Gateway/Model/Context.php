<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway\Model;

use Dynata\Rex\Core\Security\Ttl;

class Context
{
    public string $id;
    public ?array $items;
    /**
     * @var Ttl $expiration
     */
    public Ttl $expiration;
}
