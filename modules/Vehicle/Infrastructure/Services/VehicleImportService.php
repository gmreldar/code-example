<?php

declare(strict_types=1);

namespace Modules\Vehicle\Infrastructure\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Vehicle\Domain\Models\Vehicle;

/**
 * Сервис для импорта транспортных средств
 */
class VehicleImportService
{
    public function import(string $filePath): void
    {
        DB::beginTransaction();
        try {
            Vehicle::truncate();
            $vehicles = (array)json_decode(File::get($filePath), true);

            /** @var array<string, mixed> $vehicle */
            foreach ($vehicles as $vehicle) {
                $vehicle['models'] = json_encode($vehicle['models']);
                Vehicle::create($vehicle);
            }
            DB::commit();
        } catch (Exception $exception) {
            echo $exception->getMessage();
            DB::rollBack();
        }
    }
}
