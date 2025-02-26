<?php

declare(strict_types=1);

namespace Wimski\LaravelPsrHttp\Providers;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

class PsrHttpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerClient();
        $this->registerUriFactory();
        $this->registerStreamFactory();
        $this->registerUploadedFileFactory();
        $this->registerRequestFactory();
        $this->registerServerRequestFactory();
        $this->registerResponseFactory();
    }

    protected function registerClient(): void
    {
        $this->app->singleton(
            ClientInterface::class,
            fn (): ClientInterface => Psr18ClientDiscovery::find(),
        );
    }

    protected function registerUriFactory(): void
    {
        $this->app->singleton(
            UriFactoryInterface::class,
            fn (): UriFactoryInterface => Psr17FactoryDiscovery::findUriFactory(),
        );
    }

    protected function registerStreamFactory(): void
    {
        $this->app->singleton(
            StreamFactoryInterface::class,
            fn (): StreamFactoryInterface => Psr17FactoryDiscovery::findStreamFactory(),
        );
    }

    protected function registerUploadedFileFactory(): void
    {
        $this->app->singleton(
            UploadedFileFactoryInterface::class,
            fn (): UploadedFileFactoryInterface => Psr17FactoryDiscovery::findUploadedFileFactory(),
        );
    }

    protected function registerRequestFactory(): void
    {
        $this->app->singleton(
            RequestFactoryInterface::class,
            fn (): RequestFactoryInterface => Psr17FactoryDiscovery::findRequestFactory(),
        );
    }

    protected function registerServerRequestFactory(): void
    {
        $this->app->singleton(
            ServerRequestFactoryInterface::class,
            fn (): ServerRequestFactoryInterface => Psr17FactoryDiscovery::findServerRequestFactory(),
        );
    }

    protected function registerResponseFactory(): void
    {
        $this->app->singleton(
            ResponseFactoryInterface::class,
            fn (): ResponseFactoryInterface => Psr17FactoryDiscovery::findResponseFactory(),
        );
    }
}
