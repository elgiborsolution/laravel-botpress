<?php

namespace ESolution\Botpress\Auth;

use Illuminate\Http\Client\PendingRequest;

class BearerTokenStrategy implements AuthStrategyInterface
{
    /**
     * Apply bearer token authentication (for Botpress Cloud).
     *
     * @param PendingRequest $httpClient
     * @param array $config
     * @return PendingRequest
     */
    public function applyAuthentication(PendingRequest $httpClient, array $config): PendingRequest
    {
        $token = $config['api_token'] ?? null;

        if ($token) {
            return $httpClient->withToken($token);
        }

        return $httpClient;
    }
}
