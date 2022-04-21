<?php

namespace App\Tests;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * The being HTTP client instance.
     *
     * @var Client;
     */
    protected $httpClient;

    /**
     * The being mock handler instance.
     *
     * @var MockHandler
     */
    protected $mockHandler;

    /**
     * Get the HTTP client instance.
     *
     * @return Client
     */

    final protected function getHttpClient(): Client
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client([
                'handler' => HandlerStack::create($this->getMockHandler()),
                'base_uri' => 'http://fake-respondent/',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'dynata-expiration' => '',
                    'dynata-access-key' => 'ABCD1234',
                    'dynata-signature' => 'c156e91013eb715edb2b07df5491497a807206b1796bb7d031505107a9dbdcdf'
                ]
            ]);
        };
        return $this->httpClient;
    }


    final protected function buildResponse(array $data): void
    {
        $parsedResponse = new Psr7\Response(200, ['Content-Type' => 'application/json',
            'dynata-expiration' => '',
            'dynata-access-key' => 'ABCD1234',
            'dynata-signature' => 'c156e91013eb715edb2b07df5491497a807206b1796bb7d031505107a9dbdcdf'],
            json_encode($data)
        );
        $this->mockHandler->append($parsedResponse);
    }

    /**
     * Get the mock handler instance.
     *
     * @return MockHandler
     */
    final protected function getMockHandler(): MockHandler
    {
        if (is_null($this->mockHandler)) {
            $this->mockHandler = new MockHandler();
        }

        return $this->mockHandler;
    }
}