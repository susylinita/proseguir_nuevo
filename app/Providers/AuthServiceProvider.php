<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Postulacion;
use App\Policies\PostulacionPolicy;
use App\Models\KitRegistro;
use App\Policies\KitRegistroPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Postulacion::class => PostulacionPolicy::class,
         \App\Models\Postulacion::class => \App\Policies\PostulacionPolicy::class,
    KitRegistro::class => KitRegistroPolicy::class, 
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
