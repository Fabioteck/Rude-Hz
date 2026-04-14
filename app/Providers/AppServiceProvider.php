<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        // 1. Definisce il Gate per l'area Admin
        // Utilizzato da ->middleware('can:admin-only')
        Gate::define('admin-only', function (User $user) {
            return (bool) $user->is_admin;
        });

        // 2. Definisce il Gate per l'area Artista (User standard)
        // Utilizzato da ->middleware('can:user-only')
        Gate::define('user-only', function (User $user) {
            return !(bool) $user->is_admin;
        });

        /**
         * 3. LOGICA SUPER-ADMIN (Gate::before)
         * Se l'utente è un admin, ha accesso a tutto a prescindere dai Gate specifici.
         * Ritorna true per sbloccare, null per lasciare il controllo ai singoli Gate.
         */
        Gate::before(function ($user, $ability) {
            if ((bool) $user->is_admin) {
                return true;
            }
            return null; 
        });
    }
}
