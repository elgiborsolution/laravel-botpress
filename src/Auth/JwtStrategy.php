<?php

namespace ESolution\Botpress\Auth;

use Illuminate\Http\Client\PendingRequest;

class JwtStrategy implements AuthStrategyInterface
{
    /**
     * Apply JWT authentication (for Botpress CE with JWT).
     *
     * @param PendingRequest $httpClient
     * @param array $config
     * @return PendingRequest
     */
    public function applyAuthentication(PendingRequest $httpClient, array $config): PendingRequest
    {
        $secret = $config['auth_secret'] ?? null;
        $expiry = $config['jwt_expiry'] ?? 3600;

        if ($secret) {
            $token = $this->generateJwtToken($secret, $expiry);
            return $httpClient->withToken($token);
        }

        return $httpClient;
    }

    /**
     * Generate a JWT token for Botpress CE.
     *
     * @param string $secret
     * @param int $expiry
     * @return string
     */
    protected function generateJwtToken(string $secret, int $expiry): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'iat' => time(),
            'exp' => time() + $expiry,
        ];

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac(
            'sha256',
            $base64UrlHeader . '.' . $base64UrlPayload,
            $secret,
            true
        );

        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    /**
     * Base64 URL encode.
     *
     * @param string $data
     * @return string
     */
    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
