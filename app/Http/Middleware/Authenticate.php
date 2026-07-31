<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (Auth::guard('user-technical')->check()) {
                return redirect()->route('user-technical.form-login');
            }
            return route('login');
        }
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        $user = Auth::guard($guards[0] ?? 'web')->user();
        
        if ($user && $this->shouldRedirectToDashboard($request)) {
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('sa.dashboard');
            } elseif ($user->hasRole('Admin Bank Sampah')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('Masyarakat')) {
                return redirect()->route('dashboard');
            } elseif ($user->hasRole('Admin')) {
                return redirect()->route('v1.dashboard');
            }
        }

        return $next($request);
    }

    protected function shouldRedirectToDashboard($request)
    {
        return $request->path() === '/' || 
               $request->path() === '/v2/dashboard' ||
               $request->path() === '/v1/dashboard';
    }
}
