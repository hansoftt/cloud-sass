<?php

namespace Hansoft\CloudSass\Middleware;

use Closure;
use Hansoft\CloudSass\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SelectClientDatabaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $customer_code = $request->headers->get('customer-code');

        if ($customer_code) {
            $client = Client::where('subdomain', $customer_code)->first();

            if (!$client) {
                return response()->view('cloud-sass::errors.503', ['message' => 'Client not found'], 503);
            }

            if ($client->is_expired) {
                return response()->view('cloud-sass::errors.503', ['message' => 'Subscription expired. Please contact support.'], 503);
            }

            if (!$client->is_active) {
                return response()->view('cloud-sass::errors.503', ['message' => 'Account inactive. Please contact support.'], 503);
            }

            $databaseName = $client->database_name;
            $this->reconnectMySQL($databaseName);
        } else {
            $this->reconnectMySQL(config('database.connections.mysql.database'));
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
