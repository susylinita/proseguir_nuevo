<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Postulacion;
use App\Observers\PostulacionObserver;
use App\Models\KitRegistro;
use App\Observers\KitRegistroObserver;

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
        Postulacion::observe(PostulacionObserver::class);
        KitRegistro::observe(KitRegistroObserver::class);
    }
    
}
