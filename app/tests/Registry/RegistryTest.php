<?php

use App\Tests\TestCase;
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;
use Dynata\Rex\Registry\Registry;

class RegistryTest extends TestCase
{
    public function createRegistry()
    {
        $interval = \DateInterval::createFromDateString('1 day');
        $creds_provider = new BasicCredentialsProvider("pizza", "pizza-2");
        $string_signer = new StringSigner($creds_provider, $interval);
        $client = $this->getHttpClient('https://fake-respondent.qa-rex.dynata.com');
        return new Registry("https://fake-respondent.qa-rex.dynata.com", $string_signer, $client);
    }
}