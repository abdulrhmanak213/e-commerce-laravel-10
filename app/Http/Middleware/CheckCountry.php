<?php

namespace App\Http\Middleware;

use App\Models\Sale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class CheckCountry
{
    //THIS MIDDLEWARE WILL CHANGE THE DB ACCORDING THE REQUEST COUNTRY
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $position = Cache::remember('position' . $request->query('s_id'), now()->addMinutes(30), function () {
            return Location::get();
        });
        if (!$position) {
            $position = Location::get();
        }
        Config::set('app.location', $position->countryName);
        return $next($request);
    }
}

