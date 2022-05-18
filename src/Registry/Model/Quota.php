<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class Quota
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_PAUSED = 'PAUSED';
    const STATUS_CLOSED = 'CLOSED';

    public string $id;
    /**
     * @var string[]
     */
    public array $cells;
    public int $count;
    /**
     * @var string One of the STATUS_* constants
     */
    public string $status;
}
