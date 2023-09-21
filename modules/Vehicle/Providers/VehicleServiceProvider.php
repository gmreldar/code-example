<?php

declare(strict_types=1);

namespace Modules\Vehicle\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Vehicle\Api\VehicleImportServiceInterface;
use Modules\Vehicle\Api\VehicleRepositoryInterface;
use Modules\Vehicle\Application\Console\Commands\VehicleImportConsole;
use Modules\Vehicle\Infrastructure\Repositories\VehicleRepository;
use Modules\Vehicle\Infrastructure\Services\VehicleImportService;

class VehicleServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<string, string>
     */
    public array $bindings = [
        VehicleRepositoryInterface::class => VehicleRepository::class,
        VehicleImportServiceInterface::class => VehicleImportService::class
    ];

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
