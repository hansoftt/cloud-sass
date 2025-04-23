<?php

namespace Hansoft\CloudSass\Middleware;

use Closure;
use Hansoft\CloudSass\Models\Client;
use Illuminate\Http\Request;

class HandleCustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->headers->get('customer-handled')) {
            return $next($request);
        }

        $subdomain = $request->subdomain();

        if ($subdomain) {
            if ($request->routeIs(config('cloud-sass.client_route'))) {
                return $next($request);
            }
            return redirect()->route(config('cloud-sass.client_route'))->withHeaders(['customer-handled' => true]);
        } else {
            if ($request->routeIs(config('cloud-sass.admin_route'))) {
                return $next($request);
            }
            return redirect()->route(config('cloud-sass.admin_route'))->withHeaders(['customer-handled' => true]);
        }

        return $next($request);
    }
}
