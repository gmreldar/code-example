<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Garage\Application\Http\Controllers\Api\V1\GarageController;

Route::prefix('api/v1/user')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('garages', [GarageController::class, 'add']);
    });
