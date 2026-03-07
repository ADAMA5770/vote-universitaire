<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Setting::get('maintenance', '0') === '1') {
            // Les admins passent toujours
            if (Auth::check() && Auth::user()->isAdmin()) {
                return $next($request);
            }

            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
