<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry;

use Dynata\Rex\Core\RexBaseService;
use Dynata\Rex\Registry\Model\AckOpportunitiesInput;
use Dynata\Rex\Registry\Model\DownloadCollectionInput;
use Dynata\Rex\Registry\Model\ListOpportunitiesInput;
use Dynata\Rex\Registry\Model\ListProjectOpportunitiesInput;
use Dynata\Rex\Registry\Model\Opportunity;
use Dynata\Rex\Core\RexServiceException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class Registry extends RexBaseService
{
    /**
     * @param  ListOpportunitiesInput|null $input
     * @param  array<string, mixed>        $options
     * @return Opportunity[]
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function listOpportunities(?ListOpportunitiesInput $input = null, array $options = []): array
    {
        if ($input !== null) {
            $options = \array_merge(
                $options,
                ['json' => $input,]
            );
        }

        try {
            $response = $this->client->request('POST', '/list-opportunities', $options);

            /*** @var Opportunity[] $opportunities */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */
            $opportunities = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Registry\Model\Opportunity[]',
                'json'
            );

            return $opportunities;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  AckOpportunitiesInput $input
     * @param  array<string, mixed>  $options
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function ackOpportunities(AckOpportunitiesInput $input, array $options = []): Response
    {
        $options = \array_merge(
            $options,
            ['body' => $this->serializer->serialize($input, 'json'),]
        );

        try {
            return $this->client->request('POST', '/ack-opportunities', $options);
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  array<string, mixed> $options
     * @return Opportunity
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function getOpportunity(array $options = []): Opportunity
    {
        try {
            $response = $this->client->request('GET', '/get-opportunity', $options);

            /*** @var Opportunity $opportunity */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */
            $opportunity = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Registry\Model\Opportunity',
                'json'
            );

            return $opportunity;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  ListProjectOpportunitiesInput $input
     * @param  array<string, mixed>          $options
     * @return Opportunity[]
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function listProjectOpportunities(ListProjectOpportunitiesInput $input, array $options = []): array
    {
        $options = \array_merge(
            $options,
            ['body' => $this->serializer->serialize($input, 'json'),]
        );

        try {
            $response = $this->client->request('POST', '/list-project-opportunities', $options);

            /*** @var Opportunity[] $opportunities */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */
            $opportunities = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Registry\Model\Opportunity[]',
                'json'
            );

            return $opportunities;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  DownloadCollectionInput $input
     * @param  array<string, mixed>    $options
     * @return StreamInterface
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function downloadCollection(DownloadCollectionInput $input, array $options = []): StreamInterface
    {
        $options = \array_merge(
            $options,
            ['body' => $this->serializer->serialize($input, 'json'),]
        );

        try {
            $response = $this->client->request('POST', '/download-collection', $options);
            return $response->getBody();
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }
}
