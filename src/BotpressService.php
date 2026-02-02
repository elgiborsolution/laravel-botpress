<?php

namespace ESolution\Botpress;

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
     * Forward the request to Botpress server.
     */
    public function forwardRequest(string $method, string $path, array $data = [], array $headers = [])
    {
        $url = rtrim($this->getServerUrl(), '/') . '/' . ltrim($path, '/');
        $token = $this->getApiToken();

        $request = Http::withHeaders($headers);

        if ($token) {
            $request = $request->withToken($token);
        }

        return $request->send($method, $url, [
            'json' => $data,
        ]);
    }
}
