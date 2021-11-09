<?php

declare(strict_types=1);

namespace Dynata\Rex\Security;

class StringSigner implements Signer
{
    private CredentialsProvider $credentialsProvider;
    private \DateInterval $ttl;

    public function __construct(CredentialsProvider $credentialsProvider, \DateInterval $ttl) {
        $this->credentialsProvider = $credentialsProvider;
        $this->ttl = $ttl;
    }

    public function sign($subject, \DateInterval $ttl = null): Signature
    {
        if ($ttl === null) {
            $ttl = $this->ttl;
        }

        $expiration = Ttl::fromDateInterval($ttl)->expiration->toRfc3339();
        $keys = $this->credentialsProvider->getCredentials();

        try {
            $first = \hash_hmac("sha256", $subject, $expiration);
            $second = \hash_hmac("sha256", $first, $keys->accessKey);
            $signature = \hash_hmac("sha256", $second, $keys->secretKey);

            return new Signature($expiration, $keys->accessKey, $subject, $signature);
        } catch (\Exception $e) {
            throw new InvalidKeyException($e);
        }
    }
}
