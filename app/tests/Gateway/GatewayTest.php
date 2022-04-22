<?php
declare(strict_types=1);

use App\Tests\TestCase;
use Dynata\Rex\Core\RexServiceException;
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;
use Dynata\Rex\Gateway\Gateway;
use Dynata\Rex\Gateway\Model\Context;
use Dynata\Rex\Gateway\Model\CreateContextInput;
use Dynata\Rex\Gateway\Model\CreateContextOutput;
use Dynata\Rex\Gateway\Model\ExpireContextInput;
use Dynata\Rex\Gateway\Model\GetAttributeInfoInput;
use Dynata\Rex\Gateway\Model\GetAttributeInput;
use Dynata\Rex\Gateway\Model\GetContextInput;
use Dynata\Rex\Gateway\Model\PutRespondentAnswersInput;
use Dynata\Rex\Gateway\Model\PutRespondentInput;

class GatewayTest extends TestCase
{

    public function createGateway()
    {
        $interval = \DateInterval::createFromDateString('1 day');
        $creds_provider = new BasicCredentialsProvider("pizza", "pizza-2");
        $string_signer = new StringSigner($creds_provider, $interval);
        $client = $this->getHttpClient('https://fake-respondent.qa-rex.dynata.com');
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
            array('items' => ['ctx' => '1', 'gender' => 'female'])
        );
        $response = $gateway->createContext($context);
        $this->assertInstanceOf(CreateContextOutput::class, $response);

    }

    public function testCanCreateContextException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse(['id' => '1'], 500, 'post', '/create-context');
        $context = new CreateContextInput(
            "1",
            'account_id',
            null,
            array('items' => ['ctx' => '1', 'gender' => 'female'])
        );

        try {
            $gateway->createContext($context);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());

        }
    }

    public function testGetContext(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse(['id' => '1', 'account_id' => 'account_id']);
        $context = new GetContextInput("1", "account_id");
        $response = $gateway->getContext($context);
        $this->assertInstanceOf(Context::class, $response);
    }

    public function testGetContextException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse(['id' => '1'], 500, 'post', '/get-context');
        $context = new GetContextInput("1", "account_id");

        try {
            $gateway->getContext($context);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testExpireContext(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse();
        $expire = new ExpireContextInput();
        $expire->account = 'account_id';
        $expire->id = '1';
        $request = $gateway->expireContext($expire);
        $this->assertEquals(200, $request->getStatusCode());
    }

    public function testExpireContextException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([], 500, 'post', '/expire-context');
        $expire = new ExpireContextInput();
        $expire->account = 'account_id';
        $expire->id = '1';
        try {
            $gateway->expireContext($expire);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testPutRespondent(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse();
        $respondent = new PutRespondentInput();
        $respondent->respondentId = '1';
        $respondent->country = 'US';
        $respondent->language = 'en';
        $respondent->gender = 'female';
        $respondent->birthDate = '';
        $respondent->postalCode = '00000';
        $request = $gateway->putRespondent($respondent);
        $this->assertEquals(200, $request->getStatusCode());
    }

    public function testPutRespondentException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([], 500, 'post', '/put-respondent');
        $respondent = new PutRespondentInput();
        $respondent->respondentId = '1';
        $respondent->country = 'US';
        $respondent->language = 'en';
        $respondent->gender = 'female';
        $respondent->birthDate = '';
        $respondent->postalCode = '00000';
        try {
            $gateway->putRespondent($respondent);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testPutRespondentAnswers(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse();
        $respondent = new PutRespondentAnswersInput('1', 'us', ['ctx' => '1'] );
        $request = $gateway->putRespondentAnswers($respondent);
        $this->assertEquals(200, $request->getStatusCode());
    }

    public function testPutRespondentAnswersException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([], 500, 'post', '/put-respondent-answers');
        $respondent = new PutRespondentAnswersInput('1', 'us', ['ctx' => '1'] );
        try {
            $gateway->putRespondentAnswers($respondent);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testGetAttributes(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([['active' => true, 'attribute_id' => 4], ['active' => true, 'attribute_id' => 5]]);
        $attributeInput = new GetAttributeInput();
        $attributes = $gateway->getAttributes($attributeInput);
        $this->assertIsArray($attributes);
        $this->assertInstanceOf('Dynata\Rex\Gateway\Model\Attribute', $attributes[0]);
    }

    public function testGetAttributesException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([], 500, 'post', '/get-attributes');
        $attributeInput = new GetAttributeInput();
        try {
            $gateway->getAttributes($attributeInput);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testGetAttributeInfo(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([
            'id' => 4,
            'name' => 'pizza',
            'description' => 'pizza good',
            'display_name' => 'PIZZA',
            'is_active' => true
        ]);
        $attributeInfoInput = new GetAttributeInfoInput(4);
        $info = $gateway->getAttributeInfo($attributeInfoInput);
        $this->assertInstanceOf('Dynata\Rex\Gateway\Model\AttributeInfo', $info);
    }

    public function testGetAttributeInfoException(): void
    {
        $gateway = $this->createGateway();
        $this->buildResponse([], 500, 'post', '/get-attribute-info');
        $attributeInfoInput = new GetAttributeInfoInput(4);
        try {
            $gateway->getAttributeInfo($attributeInfoInput);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }
}