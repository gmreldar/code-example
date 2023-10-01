<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Application\Http\Controllers\Api\V1\UserVehicleController;

Route::prefix('api/v1/user')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('vehicles/add', [UserVehicleController::class, 'add']);
    });
