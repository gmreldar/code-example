<?php

declare(strict_types=1);

namespace Modules\Authorization\Providers;

use Illuminate\Support\ServiceProvider;

class AuthorizationProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'authorization');
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
