<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class ListProjectOpportunitiesInput
{
    public ?string $account;
    /**
     * @var int
     */
    public int $projectId;

    /**
     * @param string|null $account
     * @param int         $projectId
     */
    public function __construct(?string $account, int $projectId)
    {
        $this->account = $account;
        $this->projectId = $projectId;
    }
}
