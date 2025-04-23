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
        $subdomain = $request->subdomain();

        $request->headers->set('customer-code', $request->subdomain());

        if ($subdomain) {
            $client = Client::where('subdomain', $subdomain)->first();
            if (!$client) {
                return view('cloud-sass::errors.404', ['message' => 'Client not found']);
            }

            $databaseName = $client->database_name;
            $this->reconnectMySQL($databaseName);

            if ($request->header('customer-code') === $subdomain) {
                return $next($request);
            } else {
                return redirect()->route(config('cloud-sass.client_route'))->header('customer-code', $subdomain);
            }
        } else {
            $this->reconnectMySQL(config('database.connections.mysql.database'));

            if (!$request->hasHeader('customer-code')) {
                return redirect()->route(config('cloud-sass.client_route'))->header('customer-code', null);
            }
        }

        return $next($request);
    }

    protected function reconnectMySQL($databaseName)
    {
        Config::set('database.connections.mysql.username', config('cloud-sass.mysql_root_user'));
        Config::set('database.connections.mysql.password', config('cloud-sass.mysql_root_password'));
        Config::set('database.connections.mysql.database', $databaseName);
        DB::purge('mysql');
        DB::connection('mysql')->reconnect();
        DB::setDefaultConnection('mysql');
    }
}
