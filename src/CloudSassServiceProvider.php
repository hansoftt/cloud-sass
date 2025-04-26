<?php
namespace Hansoft\CloudSass;

use Hansoft\CloudSass\Commands\CloudSassConfigCommand;
use Hansoft\CloudSass\Commands\CloudSassHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassInstallCommand;
use Hansoft\CloudSass\Commands\CloudSassPublicHtaccessCommand;
use Hansoft\CloudSass\Commands\CloudSassSSLCommand;
use Hansoft\CloudSass\Middleware\SelectClientDatabaseMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
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
        $this->registerRequestMacros();
        $this->registerBladeDirectives();
    }

    public function packageBooted()
    {
        /** @var HttpKernel $kernel */
        $kernel     = app(Kernel::class);
        $kernel->prependMiddlewareToGroup('web', SelectClientDatabaseMiddleware::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cloud-sass');
    }

    protected function registerRequestMacros()
    {
        Request::macro('isClient', function () {
            return request()->headers->get('customer-code') !== null;
        });

        Request::macro('isAdmin', function () {
            return request()->headers->get('admin-code') === null;
        });
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('isClient', function () {
            return "<?php if (request()->headers->get('customer-code')) : ?>";
        });

        Blade::directive('endIsClient', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('unlessClient', function () {
            return "<?php if (!request()->headers->get('customer-code')) : ?>";
        });

        Blade::directive('endUnlessClient', function () {
            return "<?php endif; ?>";
        });
    }
}
