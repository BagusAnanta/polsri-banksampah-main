<?php

namespace App\Providers;

use App\Models\HistoryNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

use App\View\Composers\NavbarComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        if (app()->environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
            URL::forceScheme('https');
        }

        if (!$this->app->runningInConsole() && \Illuminate\Support\Facades\Schema::hasTable('roles')) {
            $roles = Role::pluck('name')->all();
            view()->share('roles', $roles);
        } else {
            view()->share('roles', []);
        }

        // Notification Navbar
        View::composer(
            'components.layouts.topbar',
            NavbarComposer::class
        );

        Paginator::useBootstrap();

    }
}
