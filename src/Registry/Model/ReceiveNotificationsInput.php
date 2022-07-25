<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class ReceiveNotificationsInput
{
    public ?string $account;
    public int $limit;
    public ?ShardConfig $shards;

    public function __construct(int $limit, ?ShardConfig $shards = null, ?string $account = null)
    {
        $this->account = $account;
        $this->limit = $limit;
        $this->shards = $shards;
    }
}
