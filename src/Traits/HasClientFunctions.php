<?php
namespace Hansoft\CloudSass\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait HasClientFunctions
{
    protected function reconnectMySQL($databaseName)
    {
        Config::set('database.connections.mysql.username', config('cloud-sass.mysql_root_user'));
        Config::set('database.connections.mysql.password', config('cloud-sass.mysql_root_password'));
        Config::set('database.connections.mysql.database', $databaseName);
        DB::purge('mysql');
        DB::reconnect('mysql');
        DB::setDefaultConnection('mysql');
    }

    protected function createDatabase($client)
    {
        $this->reconnectMySQL(null);

        $databaseName = $client->database_name;

        // Logic to create a database for the client
        // This is just a placeholder. You should implement the actual logic to create a database.
        // Assuming you have a method to get the database name
        // Use your database creation logic here
        // For example, using Laravel's DB facade or any other method you prefer

        DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");

        $this->reconnectMySQL($databaseName);

        $migrations_path = config('cloud-sass.migrations_location');

        if (! is_dir(base_path($migrations_path))) {
            DB::statement("USE `$databaseName`;");
            DB::unprepared(file_get_contents(base_path($migrations_path)));
        } else {
            Artisan::call('migrate', [
                '--database' => 'mysql',
                '--path'     => config('cloud-sass.migrations_location'),
                '--force'    => true,
            ]);
        }

        if (config('cloud-sass.database_seeder')) {
            Artisan::call(config('cloud-sass.database_seeder'), [
                'name' => $client->name,
                'email' => $client->email,
                'password' => $client->phone,
                'role' => 'admin',
            ]);
        }
    }

    protected function setMysqlMaxExecutionLimit()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        set_time_limit(0);
    }
}
