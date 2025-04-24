<?php
namespace Hansoft\CloudSass;

use Hansoft\CloudSass\Commands\CloudSassConfigCommand;
use Hansoft\CloudSass\Commands\CloudSassHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassInstallCommand;
use Hansoft\CloudSass\Commands\CloudSassPublicHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassSSLCommand;
use Hansoft\CloudSass\Middleware\HandleCustomerMiddleware;
use Hansoft\CloudSass\Middleware\SubdomainMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
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
            ->hasMigrations([
                'cloud_sass_subscriptions_table',
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
        Request::macro('subdomain', function () {
            $domainParts       = explode('.', request()->getHost());
            $domainPartsConfig = config('cloud-sass.domain_parts', 3);
            if (count($domainParts) <= $domainPartsConfig || $domainParts[0] === 'www') {
                return null;
            }

            return array_shift($domainParts);
        });
    }

    public function packageBooted()
    {
        $kernel     = app(Kernel::class);
        $kernel->prependMiddlewareToGroup('web', SubdomainMiddleware::class);
        //$kernel->prependMiddlewareToGroup('web', HandleCustomerMiddleware::class);

        // Allow only admin requests to access the Cloud SASS admmin panel
        $request = app(Request::class);
        if ($request->subdomain() !== null) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cloud-sass');
    }
}
