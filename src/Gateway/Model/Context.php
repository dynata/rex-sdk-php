<?php


namespace Dynata\Rex\Gateway\Model;


use Dynata\Rex\Security\Ttl;

class Context {
  public string $id;
  public ?array $items;
  public Ttl $expiration;
}