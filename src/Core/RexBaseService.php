<?php

declare(strict_types=1);

namespace Dynata\Rex\Core;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Dynata\Rex\Core\Security\Signer;

class RexBaseService
{
    protected Client $client;
    protected Serializer $serializer;

    public function __construct(string $baseUrl, Signer $signer)
    {
        $stack = HandlerStack::create();
        $stack->push(
            function (callable $handler) use ($signer) {
                return function (RequestInterface $request, array $options) use ($signer, $handler) {
                    $signingString = \hash("sha256", $request->getBody()->getContents());
                    $signature = $signer->sign($signingString);

                    $request = $request->withHeader('dynata-signing-string', $signature->signingString)
                        ->withHeader('dynata-expiration', $signature->expiration)
                        ->withHeader('dynata-access-key', $signature->accessKey)
                        ->withHeader('dynata-signature', $signature->value);

                    return $handler($request, $options);
                };
            }
        );

        $this->client = new Client(
            [
            'handler' => $stack,
            'base_uri' => $baseUrl,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            ]
        );

        $this->serializer = new Serializer(
            [
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
            ],
            [new JsonEncoder()]
        );
    }
}
