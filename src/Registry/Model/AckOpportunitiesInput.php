<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class AckOpportunitiesInput
{
    public ?string $account;
    /**
     * @var int[]
     */
    public array $opportunityIds;
}
