# Laravel PSR HTTP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/wimski/laravel-psr-http.svg?style=flat-square)](https://packagist.org/packages/wimski/laravel-psr-http)
[![Total Downloads](https://img.shields.io/packagist/dt/wimski/laravel-psr-http.svg?style=flat-square)](https://packagist.org/packages/wimski/laravel-psr-http)

This package provides Laravel bindings to make PSR HTTP requests using the [Symfony HTTP Client](https://symfony.com/doc/current/http_client.html) for the PSR-18 client
and [Nyholm's PSR-7](https://github.com/Nyholm/psr7) package for the PSR-17 factories.

## Install

```bash
composer require wimski/laravel-psr-http
```

Optionally publish the config file to adjust the default options for the [Symfony HTTP Client](https://github.com/symfony/contracts/blob/main/HttpClient/HttpClientInterface.php).
```bash
php artisan vendor:publish --tag=symfony-http-client
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

    protected ClientInterface $httpClient;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $streamFactory;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->httpClient     = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory  = $streamFactory;

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
