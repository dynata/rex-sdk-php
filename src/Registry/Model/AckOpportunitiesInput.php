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

    /**
     * @param string|null $account
     * @param int[]       $opportunityIds
     */
    public function __construct(?string $account, array $opportunityIds)
    {
        $this->account = $account;
        $this->opportunityIds = $opportunityIds;
    }
}
