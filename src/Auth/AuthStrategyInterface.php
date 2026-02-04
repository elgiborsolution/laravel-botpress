<?php

namespace ESolution\Botpress\Auth;

use Illuminate\Http\Client\PendingRequest;

interface AuthStrategyInterface
{
    /**
     * Apply authentication to the HTTP client request.
     *
     * @param PendingRequest $httpClient
     * @param array $config
     * @return PendingRequest
     */
    public function applyAuthentication(PendingRequest $httpClient, array $config): PendingRequest;
}
