<?php

namespace ESolution\Botpress;

use ESolution\Botpress\Auth\AuthStrategyInterface;
use ESolution\Botpress\Auth\BearerTokenStrategy;
use ESolution\Botpress\Auth\JwtStrategy;
use ESolution\Botpress\Auth\BasicAuthStrategy;
use ESolution\Botpress\Auth\NoAuthStrategy;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class BotpressService
{
    /**
     * Get the Botpress server URL from config or database.
     */
    public function getServerUrl(): string
    {
        if (config('botpress.use_database_config')) {
            $dbConfig = DB::table(config('botpress.table_name'))
                ->where('key', 'server_url')
                ->first();

            if ($dbConfig) {
                return $dbConfig->value;
            }
        }

        return config('botpress.server_url');
    }

    /**
     * Get the Botpress API token from config or database.
     */
    public function getApiToken(): ?string
    {
        if (config('botpress.use_database_config')) {
            $dbConfig = DB::table(config('botpress.table_name'))
                ->where('key', 'api_token')
                ->first();

            if ($dbConfig) {
                return $dbConfig->value;
            }
        }

        return config('botpress.api_token');
    }

    /**
     * Get authentication configuration from config or database.
     */
    protected function getAuthConfig(): array
    {
        $config = [
            'auth_type' => config('botpress.auth_type', 'bearer'),
            'api_token' => $this->getApiToken(),
            'auth_secret' => config('botpress.auth_secret'),
            'jwt_expiry' => config('botpress.jwt_expiry', 3600),
            'auth_username' => config('botpress.auth_username'),
            'auth_password' => config('botpress.auth_password'),
        ];

        // Override with database config if enabled
        if (config('botpress.use_database_config')) {
            $dbConfigs = DB::table(config('botpress.table_name'))
                ->whereIn('key', ['auth_type', 'auth_secret', 'jwt_expiry', 'auth_username', 'auth_password'])
                ->get()
                ->pluck('value', 'key')
                ->toArray();

            $config = array_merge($config, $dbConfigs);
        }

        return $config;
    }

    /**
     * Resolve the authentication strategy based on config.
     */
    protected function resolveAuthStrategy(): AuthStrategyInterface
    {
        $authConfig = $this->getAuthConfig();
        $authType = $authConfig['auth_type'] ?? 'bearer';

        return match ($authType) {
            'jwt' => new JwtStrategy(),
            'basic' => new BasicAuthStrategy(),
            'none' => new NoAuthStrategy(),
            default => new BearerTokenStrategy(),
        };
    }

    /**
     * Forward the request to Botpress server.
     */
    public function forwardRequest(string $method, string $path, array $data = [], array $headers = [])
    {
        $url = rtrim($this->getServerUrl(), '/') . '/' . ltrim($path, '/');

        // Create base HTTP client with headers
        $request = Http::withHeaders($headers);

        // Apply authentication strategy
        $authStrategy = $this->resolveAuthStrategy();
        $authConfig = $this->getAuthConfig();
        $request = $authStrategy->applyAuthentication($request, $authConfig);

        return $request->send($method, $url, [
            'json' => $data,
        ]);
    }
}
