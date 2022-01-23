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
}