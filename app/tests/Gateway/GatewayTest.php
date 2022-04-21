<?php
declare(strict_types=1);

use App\Tests\TestCase;
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;
use Dynata\Rex\Gateway\Gateway;
use Dynata\Rex\Gateway\Model\Context;
use Dynata\Rex\Gateway\Model\CreateContextInput;
use Dynata\Rex\Gateway\Model\CreateContextOutput;
use Dynata\Rex\Gateway\Model\ExpireContextInput;
use Dynata\Rex\Gateway\Model\GetContextInput;

class GatewayTest extends TestCase
{

    public function createGateway() {
        $interval = \DateInterval::createFromDateString('1 day');
        $creds_provider = new BasicCredentialsProvider("pizza", "pizza-2");
        $string_signer = new StringSigner($creds_provider, $interval);
        $client = $this->getHttpClient();
        return new Gateway("https://fake-respondent.qa-rex.dynata.com", $string_signer, $client);
    }

    public function testCanCreateContext(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse(['id' => '1']);
        $context = new CreateContextInput(
            "1",
            'account_id',
            null,
            array('items' => ['ctx'=> '1', 'gender' => 'female'])
        );
        $response = $gateway->createContext($context);
        $this->assertInstanceOf(CreateContextOutput::class, $response);

    }

    public function testGetContext(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse(['id' => '1', 'account_id']);
        $context = new GetContextInput("1", "account_id");
        $response = $gateway->getContext($context);
        $this->assertInstanceOf(Context::class, $response);
    }

    public function testExpireContext(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse(['id' => '1', 'account_id']);
        $expire = new ExpireContextInput();
        $expire->account = 'account_id';
        $expire->id = '1';
        $request = $gateway->expireContext($expire);
        $this->assertEquals(200, $request->getStatusCode());
    }
}