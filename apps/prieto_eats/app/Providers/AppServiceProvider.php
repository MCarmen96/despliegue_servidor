<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS en producción (para el proxy reverso)
        if(config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        //
        //Blade::if('admin', function(){

            ///** @var \App\Models\User $user */

            //$user = Auth::user();
           // return $user && $user->isAdmin();
        //});
    }
}
