<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/users/dashboard/index';

    /**
     * Define your route model bindings, patt   ern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')->namespace($this->namespace)->prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin_inventories.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/reports.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin/payments.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin/roles.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/optometrists.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('users')
                ->name('users.')
                ->group(base_path('routes/users.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('users')
                ->name('users.')
                ->group(base_path('routes/users/payment.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('technicians')
                ->name('technicians.')
                ->group(base_path('routes/technicians.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
