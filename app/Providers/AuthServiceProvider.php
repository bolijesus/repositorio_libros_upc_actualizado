<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Libro;
use App\Models\Revista;
use App\Models\Tesis;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
       // 'App\Model' => 'App\Policies\ModelPolicy',
       User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('editar-libros', function (User $user, Libro $libroUsuario) {
            return $user->isAdmin() || ($user->id == $libroUsuario->bibliografia->usuario->id);
        });
        Gate::define('editar-revistas', function (User $user, Revista $revistaUsuario) {
            return $user->isAdmin() || ($user->id == $revistaUsuario->bibliografia->usuario->id);
        });
        Gate::define('editar-tesis', function (User $user, Tesis $tesisUsuario) {
            return $user->isAdmin() || ($user->id == $tesisUsuario->bibliografia->usuario->id);
        });
    }
}
