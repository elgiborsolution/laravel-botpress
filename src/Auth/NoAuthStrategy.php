<?php

namespace ESolution\Botpress\Auth;

use Illuminate\Http\Client\PendingRequest;

class NoAuthStrategy implements AuthStrategyInterface
{
    /**
     * No authentication (for Botpress CE without auth).
     *
     * @param PendingRequest $httpClient
     * @param array $config
     * @return PendingRequest
     */
    public function applyAuthentication(PendingRequest $httpClient, array $config): PendingRequest
    {
        // No authentication headers needed
        return $httpClient;
    }
}
