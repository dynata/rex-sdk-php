<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class AckNotificationsInput
{
    /**
     * @var int[]
     */
    public array $opportunityIds;

    /**
     * @param int[]       $opportunityIds
     */
    public function __construct(array $opportunityIds)
    {
        $this->opportunityIds = $opportunityIds;
    }
}
