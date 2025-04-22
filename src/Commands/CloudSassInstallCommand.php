<?php
namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;

class CloudSassInstallCommand extends Command
{
    public $signature   = 'cloud-sass:install {--force}';
    public $description = 'Install CloudSass Package';
    public $hidden      = false;
    public $force       = false;

    public function handle(): int
    {
        $this->info('Installing CloudSass Package..');

        $result = $this->call('cloud-sass:config', [
            '--force' => $this->option('force'),
        ]);

        if ($result === self::SUCCESS) {
            $result = $this->call('vendor:publish', [
                '--tag'   => 'cloud-sass-migrations',
                '--force' => $this->option('force'),
            ]);
            if ($result === self::SUCCESS) {
                $this->info('Published CloudSass migrations.');
                $this->info('Installed CloudSass Package.');
                return self::SUCCESS;
            }

            $this->error('Failed to publish CloudSass migrations.');
            return self::FAILURE;
        }

        $this->error('Failed to install CloudSass Package.');
        return self::FAILURE;
    }
}
