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

Set these in your `.env` file:

```env
BOTPRESS_SERVER_URL=http://your-botpress-server:3000
BOTPRESS_API_TOKEN=your-api-token
BOTPRESS_ROUTE_PREFIX=botpress
BOTPRESS_USE_DATABASE_CONFIG=false
```

### Database Configuration

If you want to manage configuration via database, run the migrations:

```bash
php artisan vendor:publish --tag="botpress-migrations"
php artisan migrate
```

Then set `BOTPRESS_USE_DATABASE_CONFIG=true` in your `.env`. The package will look for keys `server_url` and `api_token` in the `botpress_configs` table.

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
