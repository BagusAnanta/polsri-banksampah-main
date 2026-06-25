<?php

namespace App\Providers;

use App\Models\HistoryNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

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

        if (!app()->environment('local')) {
            $this->app['request']->server->set('HTTPS', true);
            URL::forceScheme('https');
        }

        if (!$this->app->runningInConsole() && \Illuminate\Support\Facades\Schema::hasTable('roles')) {
            $roles = Role::pluck('name')->all();
            view()->share('roles', $roles);
        } else {
            view()->share('roles', []);
        }

        Paginator::useBootstrap();
    }
}
