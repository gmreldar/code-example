<?php

declare(strict_types=1);

namespace Modules\Expense\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Expense\Api\ExpenseCategoryRepositoryInterface;
use Modules\Expense\Api\ExpenseRepositoryInterface;
use Modules\Expense\Infrastructure\Repositories\ExpenseCategoryRepository;
use Modules\Expense\Infrastructure\Repositories\ExpenseRepository;

class ExpenseServiceProvider extends ServiceProvider
{
    /**
     * All the container bindings that should be registered.
     *
     * @var array<string, string>
     */
    public array $bindings = [
        ExpenseCategoryRepositoryInterface::class => ExpenseCategoryRepository::class,
        ExpenseRepositoryInterface::class => ExpenseRepository::class
    ];

    public function boot(): void
    {
//        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Database/Migrations');
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
