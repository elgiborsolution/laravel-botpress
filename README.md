# Laravel Botpress Bridge

A production-ready Laravel package that acts as a transparent bridge to the Botpress v12 Community Edition API.

## Features

- Bridge all Botpress API endpoints with a configurable prefix.
- Mirror same API path, payload, and response as Botpress.
- Handle configuration from `.env` or Database.
- Production ready with comprehensive tests.

## Installation

```bash
composer require elgibor-solution/laravel-botpress
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag="botpress-config"
```

### Environment Variables

The package supports both **Botpress Cloud** and **Botpress Community Edition (CE)** with different authentication methods.

#### For Botpress Cloud

```env
BOTPRESS_SERVER_URL=https://your-cloud-instance.botpress.cloud
BOTPRESS_AUTH_TYPE=bearer
BOTPRESS_API_TOKEN=bp_pat_your_token_here
BOTPRESS_ROUTE_PREFIX=botpress
BOTPRESS_USE_DATABASE_CONFIG=false
```

#### For Botpress CE (No Authentication)

Ideal for development or internal networks:

```env
BOTPRESS_SERVER_URL=http://localhost:3000
BOTPRESS_AUTH_TYPE=none
BOTPRESS_ROUTE_PREFIX=botpress
BOTPRESS_USE_DATABASE_CONFIG=false
```

#### For Botpress CE (JWT Authentication)

When your CE instance requires JWT tokens:

```env
BOTPRESS_SERVER_URL=http://your-botpress-server:3000
BOTPRESS_AUTH_TYPE=jwt
BOTPRESS_AUTH_SECRET=your-jwt-secret-key
BOTPRESS_JWT_EXPIRY=3600
BOTPRESS_ROUTE_PREFIX=botpress
BOTPRESS_USE_DATABASE_CONFIG=false
```

#### For Botpress CE (Basic Authentication)

When your CE instance uses basic auth:

```env
BOTPRESS_SERVER_URL=http://your-botpress-server:3000
BOTPRESS_AUTH_TYPE=basic
BOTPRESS_AUTH_USERNAME=admin
BOTPRESS_AUTH_PASSWORD=your-password
BOTPRESS_ROUTE_PREFIX=botpress
BOTPRESS_USE_DATABASE_CONFIG=false
```

### Authentication Types

- **`bearer`** - For Botpress Cloud (uses PAT/BAK/IAK tokens)
- **`jwt`** - For Botpress CE with JWT authentication
- **`basic`** - For Botpress CE with HTTP Basic authentication
- **`none`** - For Botpress CE without authentication (development/internal)

### Database Configuration

If you want to manage configuration via database, run the migrations:

```bash
php artisan vendor:publish --tag="botpress-migrations"
php artisan migrate
```

Then set `BOTPRESS_USE_DATABASE_CONFIG=true` in your `.env`. The package will look for configuration keys in the `botpress_configs` table:

**Available keys:**
- `server_url` - Botpress server URL
- `api_token` - API token (for bearer auth)
- `auth_type` - Authentication type (bearer, jwt, basic, none)
- `auth_secret` - JWT secret key (for JWT auth)
- `jwt_expiry` - JWT expiration in seconds (for JWT auth)
- `auth_username` - Username (for basic auth)
- `auth_password` - Password (for basic auth)

## Usage

Simply make requests to your Laravel application using the configured prefix.

For example, if your prefix is `botpress`, a request to:
`POST https://your-laravel-app.com/botpress/api/v1/bots/my-bot/converse/my-user`

Will be bridged to:
`POST http://your-botpress-server:3000/api/v1/bots/my-bot/converse/my-user`

Headers (except for excluded ones like `host`) and payloads are forwarded exactly as received.

## Testing

```bash
vendor/bin/phpunit
```

## License

MIT
