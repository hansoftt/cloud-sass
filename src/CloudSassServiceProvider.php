<?php
namespace Hansoft\CloudSass;

use Hansoft\CloudSass\Commands\CloudSassCommand;
use Hansoft\CloudSass\Commands\CloudSassHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassPublicHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassSSLCommand;
use Hansoft\CloudSass\Middleware\SubdomainMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CloudSassServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('cloud-sass')
            ->hasConfigFile()
            ->hasMigrations('cloud_sass_clients_table')
            ->hasCommands([
                CloudSassSSLCommand::class,
                CloudSassHtaccessCommand::class,
                CloudSassPublicHtaccessCommand::class,
                CloudSassCommand::class,
            ]);

    }

    public function packageRegistered()
    {
        Request::macro('subdomain', function () {
            $domainParts = explode('.', request()->getHost());
            if (count($domainParts) < 3 || $domainParts[0] === 'www') {
                return null;
            }

            return array_shift($domainParts);
        });
    }

    public function packageBooted()
    {
        /** @var Router $router */
        $router = $this->app['router'];

        $router->prependMiddlewareToGroup('web', SubdomainMiddleware::class);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cloud-sass');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
