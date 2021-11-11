<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class ShardConfig
{
    public int $count;
    public int $current;

    public function __construct(int $count, int $current)
    {
        $this->count = $count;
        $this->current = $current;
    }
}
