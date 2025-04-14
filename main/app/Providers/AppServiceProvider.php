<?php

namespace App\Providers;

use App\Models\Module;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

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
        // Get all routes
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            // Assuming route names are formatted like: 'admin.users.create'
            $routeName = $route->getName();

            if ($routeName && strpos($routeName, 'admin.') === 0) {
                // Split route name to extract module name
                $moduleName = explode('.', $routeName)[1] ?? null;

                if ($moduleName) {
                    // Create or find module
                    $module = Module::firstOrCreate(['name' => ucfirst($moduleName)]);

                    // Create permission based on route name
                    Permission::firstOrCreate([
                        'name' => $routeName,
                        'module_id' => $module->id, // Assuming Module relation exists
                        'guard_name' => 'admin'
                    ]);
                }
            }
        }
    }
}
