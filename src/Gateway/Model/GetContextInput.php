<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway\Model;

class GetContextInput
{
    public string $id;
    public string $account;

    public function __construct(string $id, string $account)
    {
        $this->id = $id;
        $this->account = $account;
    }
}
