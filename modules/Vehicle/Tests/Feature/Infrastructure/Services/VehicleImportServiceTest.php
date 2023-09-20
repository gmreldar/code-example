<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\Infrastructure\Services;

use Illuminate\Support\Facades\File;
use Modules\Vehicle\Infrastructure\Services\VehicleImportService;
use Tests\TestCase;

class VehicleImportServiceTest extends TestCase
{
    private VehicleImportService $vehicleImportService;

    public function setUp(): void
    {
        parent::setUp();
        $this->vehicleImportService = resolve(VehicleImportService::class);
    }

    public function testImport(): void
    {
        $path = base_path('dumps/pg/cars.json');
        $vehicles = (array)json_decode(File::get($path), true);
        $firstVehicle = (array)reset($vehicles);
        unset($firstVehicle['id'], $firstVehicle['models']);
        $this->vehicleImportService->import($path);
        $this->assertDatabaseHas('vehicles', $firstVehicle);
    }

    public function testImportWithInvalidJsonFile(): void
    {
        $this->expectOutputString('File does not exist at path invalid_file.json.');
        $this->vehicleImportService->import('invalid_file.json');
    }
}
