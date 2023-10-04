<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Expense\Application\Http\Controllers\Api\V1\ExpenseCategoryController;

Route::prefix('api/v1/expenses')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('category', [ExpenseCategoryController::class, 'index']);
    });
