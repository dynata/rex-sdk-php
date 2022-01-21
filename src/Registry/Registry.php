<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry;

use Dynata\Rex\Registry\Model\AckOpportunitiesInput;
use Dynata\Rex\Registry\Model\DownloadCollectionInput;
use Dynata\Rex\Registry\Model\ListOpportunitiesInput;
use Dynata\Rex\Registry\Model\ListProjectOpportunitiesInput;
use Dynata\Rex\Registry\Model\Opportunity;
use Dynata\Rex\RexServiceException;
use Dynata\Rex\Security\Signer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class Registry
{

    /**
     * @param \Dynata\Rex\Registry\Model\ListOpportunitiesInput|null $input
     * @param array<string, mixed> $options
     * @return Opportunity[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Dynata\Rex\RexServiceException
     */
    public function listOpportunities(?ListOpportunitiesInput $input = null, array $options = []): array
    {
        if ($input !== null) {
            $options = \array_merge($options, [
                'json' => $input,
            ]);
        }

        try {
            $response = $this->client->request('POST', '/list-opportunities', $options);

            /** @var Opportunity[] $opportunities */
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
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
     * @param \Dynata\Rex\Registry\Model\AckOpportunitiesInput $input
     * @param array<string, mixed> $options
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Dynata\Rex\RexServiceException
     */
    public function ackOpportunities(AckOpportunitiesInput $input, array $options = []): void
    {
        $options = \array_merge($options, [
            'body' => $this->serializer->serialize($input, 'json'),
        ]);

        try {
            $this->client->request('POST', '/ack-opportunities', $options);
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    public function getOpportunity(array $options = [])
    {
        try {
            $response = $this->client->request('GET', '/get-opportunity', $options);
            /** @var Opportunity $opportunity */
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
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

    public function listProjectOpportunities(ListProjectOpportunitiesInput $input, array $options = []) : array {
        $options = \array_merge($options, [
            'body' => $this->serializer->serialize($input, 'json'),
        ]);

        try {
            $response = $this->client->request('POST', '/list-project-opportunities', $options);
            /** @var Opportunity[] $opportunities */
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
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

    public function downloadCollection(DownloadCollectionInput $input, array $options = []) {
        $options = \array_merge($options, [
            'body' => $this->serializer->serialize($input, 'json'),
        ]);

        try {
            $response = $this->client->request('POST', '/download-collection', $options);

            return $response;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }
}
