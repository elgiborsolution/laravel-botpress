<?php

namespace ESolution\Botpress\Auth;

use Illuminate\Http\Client\PendingRequest;

class BasicAuthStrategy implements AuthStrategyInterface
{
    /**
     * Apply basic authentication (for Botpress CE with basic auth).
     *
     * @param PendingRequest $httpClient
     * @param array $config
     * @return PendingRequest
     */
    public function applyAuthentication(PendingRequest $httpClient, array $config): PendingRequest
    {
        $username = $config['auth_username'] ?? null;
        $password = $config['auth_password'] ?? null;

        if ($username && $password) {
            return $httpClient->withBasicAuth($username, $password);
        }

        return $httpClient;
    }
}
