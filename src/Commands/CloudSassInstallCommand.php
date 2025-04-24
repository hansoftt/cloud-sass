<?php
namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;
use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Subscription;

class CloudSassInstallCommand extends Command
{
    public $signature   = 'cloud-sass:install {--force}';
    public $description = 'Install CloudSass Package';
    public $hidden      = false;
    public $force       = false;

    public function handle(): int
    {
        $this->info('Installing CloudSass Package..');

        if ($this->publishConfiguration() === self::FAILURE) {
            $this->error('Failed to install CloudSass Package.');
            return self::FAILURE;
        }

        if ($this->publishAssets() === self::FAILURE) {
            $this->error('Failed to install CloudSass Package.');
            return self::FAILURE;
        }

        if ($this->publishMigrations() === self::FAILURE) {
            $this->error('Failed to install CloudSass Package.');
            return self::FAILURE;
        }

        $this->info('Seeding Database...');
        $this->seedDatabase();
        $this->info('Database seeded successfully.');

        $this->info('Installed CloudSass Package.');
        return self::SUCCESS;

        return self::FAILURE;
    }

    protected function publishConfiguration()
    {
        $result = $this->call('cloud-sass:config', [
            '--force' => $this->option('force'),
        ]);

        if ($result === self::SUCCESS) {
            $this->info('Published CloudSass configuration.');
        } else {
            $this->error('Failed to publish CloudSass configuration.');
        }

        return $result;
    }

    protected function publishAssets()
    {
        $result = $this->call('vendor:publish', [
            '--tag' => 'cloud-sass-assets',
            '--force' => $this->option('force'),
        ]);

        if ($result === self::SUCCESS) {
            $this->info('Published CloudSass assets.');
        } else {
            $this->error('Failed to publish CloudSass assets.');
        }

        return $result;
    }

    protected function publishMigrations()
    {
        $result = $this->call('vendor:publish', [
            '--tag' => 'cloud-sass-migrations',
            '--force' => $this->option('force'),
        ]);

        if ($result === self::SUCCESS) {
            $this->info('Published CloudSass migrations.');
        } else {
            $this->error('Failed to publish CloudSass migrations.');
        }

        return $result;
    }

    protected function seedDatabase()
    {
        Subscription::query()->updateOrCreate([
            'name' => 'Trial',
        ], [
            'validity' => 7,
            'no_of_users' => 5,
        ]);
    }
}
