<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry;

use Dynata\Rex\Registry\Model\AckOpportunitiesInput;
use Dynata\Rex\Registry\Model\ListOpportunitiesInput;
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
    private Client $client;
    private Serializer $serializer;

    public function __construct(string $baseUrl, Signer $signer)
    {
        $stack = HandlerStack::create();
        $stack->push(function (callable $handler) use ($signer) {
            return function (RequestInterface $request, array $options) use ($signer, $handler) {
                $signingString = \hash("sha256", $request->getBody()->getContents());
                $signature = $signer->sign($signingString);

                $request = $request->withHeader('dynata-signing-string', $signature->signingString)
                    ->withHeader('dynata-expiration', $signature->expiration)
                    ->withHeader('dynata-access-key', $signature->accessKey)
                    ->withHeader('dynata-signature', $signature->value);

                return $handler($request, $options);
            };
        });

        $this->client = new Client([
            'handler' => $stack,
            'base_uri' => $baseUrl,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->serializer = new Serializer([
            new ObjectNormalizer(
                null,
                new CamelCaseToSnakeCaseNameConverter(),
                null,
                new PhpDocExtractor(),
                null,
                null,
                [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
            ),
            new ArrayDenormalizer(),
        ], [new JsonEncoder()]);
    }

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
}
