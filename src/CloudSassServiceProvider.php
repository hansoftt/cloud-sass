<?php
namespace Hansoft\CloudSass;

use Hansoft\CloudSass\Commands\CloudSassConfigCommand;
use Hansoft\CloudSass\Commands\CloudSassHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassInstallCommand;
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
            ->hasAssets()
            ->hasViews('cloud-sass')
            ->hasRoute('web')
            ->hasMigrations([
                'cloud_sass_projects_table',
                'cloud_sass_clients_table',
            ])
            ->hasCommands([
                CloudSassInstallCommand::class,
                CloudSassConfigCommand::class,
                CloudSassSSLCommand::class,
                CloudSassHtaccessCommand::class,
                CloudSassPublicHtaccessCommand::class,
            ]);
    }

    public function packageRegistered()
    {
        if ($this->isClient()) {
            Request::macro('subdomain', function () {
                $domainParts = explode('.', request()->getHost());
                if (count($domainParts) < 3 || $domainParts[0] === 'www') {
                    return null;
                }

                return array_shift($domainParts);
            });
        }
    }

    public function packageBooted()
    {
        if ($this->isClient()) {
            /** @var Router $router */
            $router = $this->app['router'];
            $router->prependMiddlewareToGroup('web', SubdomainMiddleware::class);
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cloud-sass');
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }
    }

    protected function isAdmin(): bool
    {
        return config('cloud-sass.type') === 'admin';
    }

    protected function isClient(): bool
    {
        return config('cloud-sass.type') === 'client';
    }
}
