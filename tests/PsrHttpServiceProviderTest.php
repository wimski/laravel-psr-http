<?php

declare(strict_types=1);

namespace Wimski\LaravelPsrHttp\Tests;

use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Wimski\LaravelPsrHttp\Providers\PsrHttpServiceProvider;

class PsrHttpServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PsrHttpServiceProvider::class,
        ];
    }

    #[Test]
    public function it_registers_http_psr_services(): void
    {
        $client = $this->app?->make(ClientInterface::class);
        self::assertInstanceOf(ClientInterface::class, $client);

        $uriFactory = $this->app?->make(UriFactoryInterface::class);
        self::assertInstanceOf(UriFactoryInterface::class, $uriFactory);

        $streamFactory = $this->app?->make(StreamFactoryInterface::class);
        self::assertInstanceOf(StreamFactoryInterface::class, $streamFactory);

        $uploadedFileFactory = $this->app?->make(UploadedFileFactoryInterface::class);
        self::assertInstanceOf(UploadedFileFactoryInterface::class, $uploadedFileFactory);

        $requestFactory = $this->app?->make(RequestFactoryInterface::class);
        self::assertInstanceOf(RequestFactoryInterface::class, $requestFactory);

        $serverRequestFactory = $this->app?->make(ServerRequestFactoryInterface::class);
        self::assertInstanceOf(ServerRequestFactoryInterface::class, $serverRequestFactory);

        $responseFactory = $this->app?->make(ResponseFactoryInterface::class);
        self::assertInstanceOf(ResponseFactoryInterface::class, $responseFactory);
    }
}
