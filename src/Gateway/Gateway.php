<?php

declare(strict_types=1);

namespace Dynata\Rex\Gateway;

use Dynata\Rex\Core\RexBaseService;
use Dynata\Rex\Core\RexServiceException;
use Dynata\Rex\Gateway\Model\Attribute;
use Dynata\Rex\Gateway\Model\AttributeInfo;
use Dynata\Rex\Gateway\Model\Context;
use Dynata\Rex\Gateway\Model\CreateContextInput;
use Dynata\Rex\Gateway\Model\CreateContextOutput;
use Dynata\Rex\Gateway\Model\ExpireContextInput;
use Dynata\Rex\Gateway\Model\GetAttributeInfoInput;
use Dynata\Rex\Gateway\Model\GetAttributeInput;
use Dynata\Rex\Gateway\Model\GetContextInput;
use Dynata\Rex\Gateway\Model\PutRespondentAnswersInput;
use Dynata\Rex\Gateway\Model\PutRespondentInput;
use Dynata\Rex\Gateway\Model\RequestContext;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class Gateway extends RexBaseService
{
    /**
     * @param  CreateContextInput  $input
     * @param  RequestContext|null $ctx
     * @return CreateContextOutput
     * @throws GuzzleException
     * @throws RexServiceException
     */

    public function createContext(CreateContextInput $input, ?RequestContext $ctx = null): CreateContextOutput
    {
        try {
            if ($ctx !== null) {
                $input = \array_merge(
                    ['ctx' => $ctx],
                    ['body' => $this->serializer->serialize($input, 'json'),]
                );
            } else {
                $input = ['body' => $this->serializer->serialize($input, 'json')];
            }
            $response = $this->client->request('POST', '/create-context', $input);
            /*** @var CreateContextOutput $out */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */
            $out = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Gateway\Model\CreateContextOutput',
                'json'
            );

            return $out;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  GetContextInput $input
     * @return Context
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function getContext(GetContextInput $input): Context
    {
        $options = [
            'body' => $this->serializer->serialize($input, 'json'),
        ];
        try {
            $response = $this->client->request('POST', '/get-context', $options);
            /*** @var Context $context */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */
            $context = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Gateway\Model\Context',
                'json'
            );

            return $context;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  ExpireContextInput $input
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function expireContext(ExpireContextInput $input): Response
    {
        $options = [
            'body' => $this->serializer->serialize($input, 'json'),
        ];
        try {
            return $this->client->request('POST', '/expire-context', $options);
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  PutRespondentInput   $input
     * @param  array<string, mixed> $options
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function putRespondent(PutRespondentInput $input, array $options = []): Response
    {
        $options = \array_merge(
            $options,
            ['body' => $this->serializer->serialize($input, 'json'),]
        );
        try {
            return $this->client->request('POST', '/put-respondent', $options);
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    /**
     * @param  PutRespondentAnswersInput $input
     * @param  array<string, mixed>      $options
     * @throws GuzzleException
     * @throws RexServiceException
     */
    public function putRespondentAnswers(PutRespondentAnswersInput $input, array $options = []): Response
    {
        $options = \array_merge(
            $options,
            [
                'body' => $this->serializer->serialize($input, 'json'),
            ]
        );
        try {
            return $this->client->request('POST', '/put-respondent-answers', $options);
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    public function getAttributes(GetAttributeInput $input)
    {
        $options = [
            'body' => $this->serializer->serialize($input, 'json'),
        ];
        try {
            $response = $this->client->request('POST', '/get-attributes', $options);
            /*** @var Attribute[] $attributes */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */
            $attributes = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Gateway\Model\Attribute[]',
                'json'
            );
            return $attributes;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    public function getAttributeInfo(GetAttributeInfoInput $input)
    {
        $options = [
            'body' => $this->serializer->serialize($input, 'json'),
        ];
        try {
            $response = $this->client->request('POST', '/get-attribute-info', $options);
            /*** @var AttributeInfo $attributeInfo */
            /*** @noinspection PhpUnnecessaryLocalVariableInspection */

            $attributeInfo = $this->serializer->deserialize(
                $response->getBody()->getContents(),
                'Dynata\Rex\Gateway\Model\AttributeInfo',
                'json'
            );
            return $attributeInfo;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }
}
