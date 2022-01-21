<?php

declare(strict_types=1);

namespace Dynata\Rex;

class RexServiceException extends RexClientException
{
    public string $rawResponse;
    public int $statusCode;
    public string $serviceName;
}
