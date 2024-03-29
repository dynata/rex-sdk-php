<?php

declare(strict_types=1);

namespace Dynata\Rex\tests\Registry;

use App\Tests\TestCase;
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;
use Dynata\Rex\Registry\Model\AckNotificationsInput;
use Dynata\Rex\Registry\Model\AckOpportunitiesInput;
use Dynata\Rex\Registry\Model\DownloadCollectionInput;
use Dynata\Rex\Registry\Model\ListOpportunitiesInput;
use Dynata\Rex\Registry\Model\ReceiveNotificationsInput;
use Dynata\Rex\Registry\Model\ListProjectOpportunitiesInput;
use Dynata\Rex\Registry\Registry;
use Exception;
use Psr\Http\Message\StreamInterface;

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

    public function testListOpportunities(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([['id' => '1'], ['id' => '2']]);
        $list = new ListOpportunitiesInput(1);
        $response = $registry->listOpportunities($list);
        $this->assertIsArray($response);
        $this->assertInstanceOf('Dynata\Rex\Registry\Model\Opportunity', $response[0]);
    }

    public function testListOpportunitiesException(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([], 500, 'post', '/list-opportunities');
        $list = new ListOpportunitiesInput(1);
        try {
            $registry->listOpportunities($list);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testReceiveNotifications(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([['id' => '1'], ['id' => '2']]);
        $list = new ReceiveNotificationsInput(1);
        $response = $registry->receiveNotifications($list);
        $this->assertIsArray($response);
        $this->assertInstanceOf('Dynata\Rex\Registry\Model\Notification', $response[0]);
    }

    public function testReceiveNotificationsException(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([], 500, 'post', '/receive-notifications');
        $list = new ReceiveNotificationsInput(1);
        try {
            $registry->receiveNotifications($list);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testAckOpportunities(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse();
        $list = new AckOpportunitiesInput('1', [1, 2, 3]);
        $response = $registry->ackOpportunities($list);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAckOpportunitiesException(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([], 500, 'post', '/ack-opportunities');
        $list = new AckOpportunitiesInput('1', [1, 2, 3]);
        try {
            $registry->ackOpportunities($list);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testAckNotifications(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse();
        $list = new AckNotificationsInput([1, 2, 3]);
        $response = $registry->ackNotifications($list);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAckNotificationsException(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([], 500, 'post', '/ack-notifications');
        $list = new AckNotificationsInput([1, 2, 3]);
        try {
            $registry->ackNotifications($list);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testGetOpportunity(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse();
        $response = $registry->getOpportunity();
        $this->assertInstanceOf('Dynata\Rex\Registry\Model\Opportunity', $response);
    }

    public function testGetOpportunityException(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([], 500, 'post', '/get-opportunity');
        try {
            $registry->getOpportunity();
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testListProjectOpportunities(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([['id' => '1'], ['id' => '2']]);
        $list = new ListProjectOpportunitiesInput('1', 1);

        $response = $registry->listProjectOpportunities($list);
        $this->assertIsArray($response);
        $this->assertInstanceOf('Dynata\Rex\Registry\Model\Opportunity', $response[0]);
    }

    public function testListProjectOpportunitiesException(): void
    {
        $registry = $this->createRegistry();
        $list = new ListProjectOpportunitiesInput('1', 1);
        $this->buildResponse([], 500, 'post', '/list-project-opportunities');
        try {
            $registry->listProjectOpportunities($list);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }

    public function testDownloadCollection(): void
    {
        $registry = $this->createRegistry();
        $this->buildResponse([['id' => '1'], ['id' => '2']]);
        $collection = new DownloadCollectionInput('account_id', 1);
        $response = $registry->downloadCollection($collection);
        $this->assertInstanceOf(StreamInterface::class, $response);
    }

    public function testDownloadCollectionException(): void
    {
        $registry = $this->createRegistry();
        $collection = new DownloadCollectionInput('account_id', 1);
        $this->buildResponse([], 500, 'post', '/download-collection');
        try {
            $registry->downloadCollection($collection);
        } catch (Exception $e) {
            $this->assertEquals('Error Communicating with Server', $e->getMessage());
        }
    }
}
