<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CreatePermissionsFromRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $routeName = $route->getName();

            if ($routeName && strpos($routeName, 'admin.') === 0) {
                $moduleName = explode('.', $routeName)[1] ?? null;

                if ($moduleName) {
                    $module = Module::firstOrCreate(['name' => ucfirst($moduleName)]);
                    $permissionExists = Permission::where('name', $routeName)->first();
                    if (is_null($permissionExists)) {
                        Permission::firstOrCreate([
                            'name' => $routeName,
                            'guard_name' => 'admin',
                            'module_id' => $module->id
                        ]);
                        $this->info('Created route permission for: ' . $route->getName());
                    }
                }
            }
        }

        $this->info('Permissions created successfully!');
    }
}
