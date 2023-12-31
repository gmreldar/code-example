<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1/user')
    ->middleware(['auth:sanctum'])
    ->group(function () {});
