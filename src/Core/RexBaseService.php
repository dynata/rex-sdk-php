<?php


namespace Dynata\Rex\Core;


class RexBaseService {
    protected Client $client;
    protected Serializer $serializer;

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
}