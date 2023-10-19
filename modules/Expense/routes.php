<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Expense\Application\Http\Controllers\Api\V1\ExpenseCategoryController;
use Modules\Expense\Application\Http\Controllers\Api\V1\ExpenseController;

Route::prefix('api/v1/expenses')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('', [ExpenseController::class, 'create']);

        Route::get('category', [ExpenseCategoryController::class, 'index']);
    });
