<?php

declare(strict_types=1);

namespace Wimski\LaravelPsrHttp\Providers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

class LaravelPsrHttpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->publishes([
            $this->getConfigPath() => config_path('symfony-http-client.php'),
        ], 'config');

        $this->mergeConfigFrom(
            $this->getConfigPath(),
            'symfony-http-client',
        );

        $this->registerFactories();

        $this->app->singleton(ClientInterface::class, function (Application $app) {
            /** @var Config $config */
            $config = $app->make(Config::class);

            return new Psr18Client(
                HttpClient::create(
                    $config->get('symfony-http-client.default_options'),
                    $config->get('symfony-http-client.max_host_connections'),
                    $config->get('symfony-http-client.max_pending_pushes'),
                ),
                $app->make(ResponseFactoryInterface::class),
                $app->make(StreamFactoryInterface::class),
            );
        });
    }

    protected function registerFactories(): void
    {
        $this->app->singleton(RequestFactoryInterface::class, Psr17Factory::class);
        $this->app->singleton(ResponseFactoryInterface::class, Psr17Factory::class);
        $this->app->singleton(ServerRequestFactoryInterface::class, Psr17Factory::class);
        $this->app->singleton(StreamFactoryInterface::class, Psr17Factory::class);
        $this->app->singleton(UploadedFileFactoryInterface::class, Psr17Factory::class);
        $this->app->singleton(UriFactoryInterface::class, Psr17Factory::class);
    }

    protected function getConfigPath(): string
    {
        return __DIR__ .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            'config' .
            DIRECTORY_SEPARATOR .
            'symfony-http-client.php';
    }
}
