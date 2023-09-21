<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\Infrastructure\Repositories;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Vehicle\Infrastructure\Repositories\VehicleRepository;
use Tests\TestCase;

class VehicleRepositoryTest extends TestCase
{
    private VehicleRepository $vehicleRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->vehicleRepository = resolve(VehicleRepository::class);
    }

    public function testRecreate(): void
    {
        $path = base_path('dumps/pg/cars.json');
        $vehicles = (array)json_decode(File::get($path), true);
        $firstVehicle = [(array)reset($vehicles)];

        $this->vehicleRepository->recreate($firstVehicle);
        $firstVehicle = reset($firstVehicle);
        unset($firstVehicle['id'], $firstVehicle['models']);
        $this->assertDatabaseHas('vehicles', $firstVehicle);
    }

    public function testRecreateFailed(): void
    {
        $testVehicles = [
            [
                'name' => 'Messerschmitt',
                'cyrillic_name' => 'Мессершмитт',
                'is_popular' => false,
                'country' => "Германия",
            ],
        ];
        $this->expectException(Exception::class);
        $this->vehicleRepository->recreate($testVehicles);
    }
}
