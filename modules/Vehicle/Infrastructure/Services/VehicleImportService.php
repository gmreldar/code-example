<?php

declare(strict_types=1);

namespace Modules\Vehicle\Infrastructure\Services;

use Illuminate\Support\Facades\File;
use Modules\Vehicle\Domain\Models\Vehicle;

/**
 * Сервис для импорта транспортных средств
 */
class VehicleImportService
{
    public function import(string $filePath): void
    {
        Vehicle::truncate();
        $vehicles = (array)json_decode(File::get($filePath), true);

        /** @var array<string, mixed> $vehicle */
        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
