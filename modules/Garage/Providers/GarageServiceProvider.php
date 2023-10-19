<?php

declare(strict_types=1);

namespace Modules\Garage\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Garage\Api\GarageRepositoryInterface;
use Modules\Garage\Infrastructure\Repositories\GarageRepository;

class GarageServiceProvider extends ServiceProvider
{
    /**
     * All the container bindings that should be registered.
     *
     * @var array<string, string>
     */
    public array $bindings = [
        GarageRepositoryInterface::class => GarageRepository::class
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Database/Migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
}
