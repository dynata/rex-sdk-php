<?php


namespace Dynata\Rex\Gateway\Model;


class CreateContextInput {

  public string $id;
  public string $account;
  public ?array $items;
  public string $expiration;

  public function __construct(string $id, string $account, string $expiration, ?array $items = null)
  {
    $this->id = $id;
    $this->account = $account;
    $this->expiration = $expiration;
    $this->items = $items;
  }
}