<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway\Model;

use Dynata\Rex\Security\Ttl;

class RequestContext
{
    public ?int $socketTimeout;
    public ?int $connectTimeout;
    public ?int $connectionRequestTimeout;
    public ?Ttl $ttl;

  /**
   * RequestContext constructor.
   * @param int|null $socketTimeout
   * @param int|null $connectTimeout
   * @param int|null $connectionRequestTimeout
   * @param Ttl|null $ttl
   */
    public function __construct(?int $socketTimeout, ?int $connectTimeout, ?int $connectionRequestTimeout, ?Ttl $ttl)
    {
        $this->socketTimeout = $socketTimeout;
        $this->connectTimeout = $connectTimeout;
        $this->connectionRequestTimeout = $connectionRequestTimeout;
        $this->ttl = $ttl;
    }
}
