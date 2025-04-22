<?php

namespace Hansoft\CloudSass\Middleware;

use Closure;
use Hansoft\CloudSass\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SubdomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->reconnectSqlite();

        $subdomain = $request->subdomain();

        if ($subdomain) {
            $client = Client::where('subdomain', $subdomain)->first();
            if (!$client) {
                return view('cloud-sass::errors.404', ['message' => 'Client not found']);
            }

            $databaseName = $client->database_name;
            $this->reconnectMySQL($databaseName);
        } else {
            $this->reconnectSqlite();
        }

		$request->headers->set('customer-code', $request->subdomain());

        return $next($request);
    }

    protected function reconnectMySQL($databaseName)
    {
        Config::set('database.connections.mysql.username', 'root');
        Config::set('database.connections.mysql.password', 'root');
        Config::set('database.connections.mysql.database', $databaseName);
        DB::purge('mysql');
        DB::connection('mysql')->reconnect();
        DB::setDefaultConnection('mysql');
    }

    protected function reconnectSqlite()
    {
        DB::purge('sqlite');
        DB::connection('sqlite')->reconnect();
        DB::setDefaultConnection('sqlite');
    }
}
