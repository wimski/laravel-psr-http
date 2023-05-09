[![Latest Stable Version](http://poser.pugx.org/wimski/laravel-psr-http/v)](https://packagist.org/packages/wimski/laravel-psr-http)
[![Coverage Status](https://coveralls.io/repos/github/wimski/laravel-psr-http/badge.svg?branch=master)](https://coveralls.io/github/wimski/laravel-psr-http?branch=master)
[![PHPUnit](https://github.com/wimski/laravel-psr-http/actions/workflows/phpunit.yml/badge.svg)](https://github.com/wimski/laravel-psr-http/actions/workflows/phpunit.yml)
[![PHPStan](https://github.com/wimski/laravel-psr-http/actions/workflows/phpstan.yml/badge.svg)](https://github.com/wimski/laravel-psr-http/actions/workflows/phpstan.yml)

# Laravel PSR HTTP

This package provides Laravel bindings to make PSR HTTP requests using [discovery](https://github.com/php-http/discovery).

## Install

```bash
composer require wimski/laravel-psr-http
```

## Usage example

```php
<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class TestCommand extends Command
{
    protected $signature = 'http:test';
    protected $description = 'Test the HTTP client';

    public function __construct(
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $stream = $this->streamFactory->createStream(json_encode([
            'title'  => 'foo',
            'body'   => 'bar',
            'userId' => 1,
        ]));

        $request = $this->requestFactory->createRequest('POST', 'https://jsonplaceholder.typicode.com/posts')
            ->withHeader('Content-type', 'application/json; charset=UTF-8')
            ->withBody($stream);

        try {
            $response = $this->httpClient->sendRequest($request);
            dump(json_decode((string) $response->getBody(), true));
        } catch (ClientExceptionInterface $exception) {
            dump($exception->getMessage());
        }
    }
}
```
