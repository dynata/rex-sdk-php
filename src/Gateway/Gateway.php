<?php


namespace Dynata\Rex\Gateway;


use Dynata\Rex\Core\RexBaseService;
use Dynata\Rex\Gateway\Model\Context;
use Dynata\Rex\Gateway\Model\CreateContextInput;
use Dynata\Rex\Gateway\Model\CreateContextOutput;
use Dynata\Rex\Gateway\Model\GetContextInput;
use Dynata\Rex\RequestContext;
use Dynata\Rex\RexServiceException;

class Gateway extends RexBaseService {
    public function createContext(CreateContextInput $input, ?RequestContext $ctx = null) {
        try {
            if($ctx != null) {
                $input = \array_merge([
                    'ctx' => $ctx
                ], [
                    'body' => $this->serializer->serialize($input, 'json'),
                ]);
                $response = $this->client->request('POST', '/create-context', $input);
                /** @var CreateContextOutput $out */
                /** @noinspection PhpUnnecessaryLocalVariableInspection */
                $out = $this->serializer->deserialize(
                    $response->getBody()->getContents(),
                    'Dynata\Rex\Gateway\Model\CreateContextOutput',
                    'json'
                );
            }

            return $out;
        } catch (BadResponseException $e) {
            $ex = new RexServiceException($e->getMessage(), 0, $e);
            $ex->statusCode = $e->getResponse()->getStatusCode();
            $ex->rawResponse = $e->getResponse()->getBody()->getContents();

            throw $ex;
        }
    }

    public function getContext(GetContextInput $input) {

        try {
            $response = $this->client->request('POST', '/get-context', $input);

            /** @var Context $context */
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
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
}