<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class DownloadCollectionInput
{
    public ?string $account;
    /**
    * @var int
    */
    public int $collectionId;

    /**
     * @param string|null $account
     * @param int $collectionId
     */
    public function __construct(?string $account, int $collectionId)
    {
        $this->account = $account;
        $this->collectionId = $collectionId;
    }
}
