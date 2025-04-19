<?php
namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;

class CloudSassInstallCommand extends Command
{
    public $signature   = 'cloud-sass:install {--client} {--admin} {--force}';
    public $description = 'Install CloudSass Package';
    public $hidden      = false;
    public $force       = false;

    public function handle(): int
    {
        if ($this->option('client') && $this->option('admin')) {
            $this->error('You cannot use --client and --admin at the same time.');
            return self::FAILURE;
        }

        if ($this->option('client')) {
            $this->info('Installing CloudSass Client Package..');

            $result = $this->call('cloud-sass:config', [
                '--client' => $this->option('client'),
                '--force'  => $this->option('force'),
            ]);

            if ($result === self::SUCCESS) {
                $this->info('Installed CloudSass Client Package.');
                return self::SUCCESS;
            }

            $this->error('Failed to install CloudSass Client Package.');
            return self::FAILURE;
        }

        if ($this->option('admin')) {
            $this->info('Installing CloudSass Admin Package..');

            $result = $this->call('cloud-sass:config', [
                '--admin' => $this->option('admin'),
                '--force' => $this->option('force'),
            ]);

            if ($result === self::SUCCESS) {
                $result = $this->call('vendor:publish', [
                    '--tag'   => 'cloud-sass-migrations',
                    '--force' => $this->option('force'),
                ]);
                if ($result === self::SUCCESS) {
                    $this->info('Published CloudSass migrations.');
                    $this->info('Installed CloudSass Admin Package.');
                    return self::SUCCESS;
                }

                $this->error('Failed to publish CloudSass migrations.');
                return self::FAILURE;
            }

            $this->error('Failed to install CloudSass Admin Package.');
            return self::FAILURE;
        }

        $this->error('You must specify either --client or --admin.');
        return self::FAILURE;
    }
}
