<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Authorization\Application\Http\Controllers\Api\V1\AuthorizationController;
use Modules\Authorization\Application\Http\Controllers\Api\V1\RegistrationController;

Route::prefix('api/v1')
    ->group(function () {
        Route::post('login', [AuthorizationController::class, 'login']);

        Route::post('register', [RegistrationController::class, 'register']);
    });
