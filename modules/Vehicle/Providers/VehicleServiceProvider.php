<?php

declare(strict_types=1);

namespace Modules\Vehicle\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Vehicle\Application\Console\Commands\VehicleImportConsole;

class VehicleServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<string, string>
     */
    public array $bindings = [];

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Database/Migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                VehicleImportConsole::class
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
