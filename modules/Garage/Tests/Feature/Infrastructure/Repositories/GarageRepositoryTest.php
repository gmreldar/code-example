<?php

declare(strict_types=1);

namespace Modules\Garage\Tests\Feature\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Str;
use Modules\Garage\Domain\Models\Garage;
use Modules\Garage\Infrastructure\Repositories\GarageRepository;
use Modules\User\Domain\Models\User;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;
use Tests\TestCase;

class GarageRepositoryTest extends TestCase
{
    public function testCreateUserVehicle(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::inRandomOrder()->first();
        /*** @var $vehicle Vehicle */
        $models = $vehicle?->models;
        if (!$models) {
            throw new RecordsNotFoundException("Models nof found");
        }
        $userVehicleData = [
            'vehicle_id' => $vehicle->id,
            'model_id' => $models[0]['id'],
            'manufacture_year' => rand($models[0]['year_from'], $models[0]['year_to']),
            'vin' => Str::random(17),
            'initial_mileage' => rand(20_000, 200_000),
            'current_mileage' => rand(20_000, 200_000),
            'power' => rand(100, 300),
            'purchase_date' => now()->subYears(rand (1, 3)),
            'fuel_type' => FuelType::AI_95
        ];

        $repository = app(GarageRepository::class);
        $garage = $repository->create($user, $userVehicleData);

        $this->assertInstanceOf(Garage::class, $garage);
        $this->assertEquals($user->id, $garage->user_id);
        $this->assertEquals($userVehicleData['vehicle_id'], $garage->vehicle_id);
        $this->assertEquals($userVehicleData['model_id'], $garage->model_id);
        $this->assertEquals($userVehicleData['manufacture_year'], $garage->manufacture_year);
        $this->assertEquals($userVehicleData['vin'], $garage->vin);
        $this->assertEquals($userVehicleData['initial_mileage'], $garage->initial_mileage);
        $this->assertEquals($userVehicleData['current_mileage'], $garage->current_mileage);
        $this->assertEquals($userVehicleData['power'], $garage->power);
        $this->assertEquals($userVehicleData['purchase_date']->format('Y-m-d'), $garage->purchase_date->format('Y-m-d'));
        $this->assertEquals($userVehicleData['fuel_type'], $garage->fuel_type);
    }

    public function testFindAllUserVehicles(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 3; $i++) {
            $vehicle = Vehicle::inRandomOrder()->first();
            /*** @var $vehicle Vehicle */
            $models = $vehicle?->models;
            if (!$models) {
                throw new RecordsNotFoundException("Models nof found");
            }
            $mileage = rand(20_000, 200_000);
            $userVehicleData = [
                'vehicle_id' => $vehicle->id,
                'model_id' => $models[0]['id'],
                'manufacture_year' => rand($models[0]['year_from'], $models[0]['year_to']),
                'vin' => Str::random(17),
                'initial_mileage' => $mileage,
                'current_mileage' => $mileage,
                'power' => rand(100, 300),
                'purchase_date' => now()->subYears(rand (1, 3)),
                'fuel_type' => FuelType::AI_95
            ];

            $repository = app(GarageRepository::class);
            $repository->create($user, $userVehicleData);
        }


        $repository = app(GarageRepository::class);
        $result = $repository->findAll($user->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
    }
}
