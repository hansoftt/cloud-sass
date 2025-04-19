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
            $this->callSilent('vendor:publish', [
                '--tag' => 'cloud-sass-config',
                '--force' => $this->option('force'),
            ]);
            return self::SUCCESS;
        }

        if ($this->option('admin')) {
            $this->info('Installing CloudSass Admin Package..');
            $this->callSilent('vendor:publish', [
                '--tag' => 'cloud-sass-config',
                '--force' => $this->option('force'),
            ]);
            $this->callSilent('vendor:publish', [
                '--tag' => 'cloud-sass-migrations',
                '--force' => $this->option('force'),
            ]);
            return self::SUCCESS;
        }

        $this->error('You must specify either --client or --admin.');
        return self::FAILURE;
    }
}
