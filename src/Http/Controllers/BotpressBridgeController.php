<?php

namespace ESolution\Botpress\Http\Controllers;

use ESolution\Botpress\BotpressService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BotpressBridgeController extends Controller
{
    protected $botpress;

    public function __construct(BotpressService $botpress)
    {
        $this->botpress = $botpress;
    }

    /**
     * Handle the bridged API request.
     */
    public function handle(Request $request, $any)
    {
        $method = $request->method();
        $path = $any;
        $data = $request->all();
        $headers = $this->getFilteredHeaders($request);

        $response = $this->botpress->forwardRequest($method, $path, $data, $headers);

        return response($response->body(), $response->status())
            ->withHeaders($this->getForwardedHeaders($response->headers()));
    }

    /**
     * Filter request headers to forward.
     */
    protected function getFilteredHeaders(Request $request): array
    {
        // Exclude headers that should not be forwarded or will be added by HttpClient
        $exclude = ['host', 'content-length', 'authorization'];

        return collect($request->headers->all())
            ->mapWithKeys(fn($value, $key) => [strtolower($key) => $value[0]])
            ->except($exclude)
            ->toArray();
    }

    /**
     * Extract headers from Botpress response to return to client.
     */
    protected function getForwardedHeaders(array $headers): array
    {
        $exclude = ['transfer-encoding', 'content-length', 'connection'];

        return collect($headers)
            ->mapWithKeys(fn($value, $key) => [strtolower($key) => $value[0]])
            ->except($exclude)
            ->toArray();
    }
}
