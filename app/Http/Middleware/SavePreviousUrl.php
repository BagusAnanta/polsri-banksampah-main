<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SavePreviousUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() === 'GET' && !$request->ajax()) {
            $excludedRoutes = ['jenis_sampahs.create', 'jenis_sampahs.show', 'user.login', 'registerUser']; // Tambahkan rute detail
            $currentRouteName = $request->route() ? $request->route()->getName() : null;

            if (!in_array($currentRouteName, $excludedRoutes)) {
                session(['previous_url' => url()->full()]);
            }
        }

        return $next($request);
    }
}
