<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Vehicle\Application\Http\Controllers\Api\V1\VehicleController;

Route::prefix('api/v1')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('vehicles', [VehicleController::class, 'index']);
    });
