<?php

/*

#!/usr/bin/bash
certbot --non-interactive --cert-name schools.24x7s.in --key-type ecdsa
    --agree-tos --email profgdalin@gmail.com certonly --authenticator dns-standalone
    --dns-standalone-address=$(hostname -I) --dns-standalone-port=53
    -d schools.24x7s.in -d '*.schools.24x7s.in'
    --force-renewal

*/

namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;

class CloudSassSSLCommand extends Command
{
    public $signature   = 'cloud-sass:ssl {--site} {--email}';
    public $description = 'Generate SSL certificate for CloudSass';
    public $hidden      = true;
    public $force       = false;

    protected $command = [
        'certbot --non-interactive --cert-name %s --key-type ecdsa',
        '--agree-tos --email %s certonly --authenticator dns-standalone',
        '--dns-standalone-address=$(hostname -I) --dns-standalone-port=53',
        '-d %s -d \'*.%s\'',
        '--force-renewal',
    ];

    public function handle(): int
    {
        $this->info('Generating SSL certificate...');

        if (! $this->option('site')) {
            $this->error('Site name is required.');
            return self::FAILURE;
        }
        $site = $this->option('site');

        if (! $this->option('email')) {
            $this->error('Site email is required.');
            return self::FAILURE;
        }
        $email = $this->option('email');

        $this->info('Generating command...');
        $command = $this->generateCommand($site, $email);
        $this->info('Command generated:');
        $this->line($command);

        $this->info('Executing command...');
        $output    = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        if ($returnVar !== 0) {
            $this->error('Command failed with return code: ' . $returnVar);
            $this->line('Output: ' . implode("\n", $output));
            return self::FAILURE;
        }
        $this->info('SSL certificate generated successfully.');
        $this->line('Output: ' . implode("\n", $output));
        return self::SUCCESS;
    }

    protected function generateCommand($site, $email): string
    {
        return sprintf(
            implode(' ', $this->command),
            $site,
            $email,
            $site,
            $site
        );
    }
}
