<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Str;
use Modules\User\Domain\Models\User;
use Modules\User\Domain\Models\UserVehicle;
use Modules\User\Infrastructure\Repositories\UserVehicleRepository;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;
use Tests\TestCase;

class UserVehicleRepositoryTest extends TestCase
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
            'mileage' => rand(20_000, 200_000),
            'power' => rand(100, 300),
            'purchase_date' => now()->subYears(rand (1, 3)),
            'fuel_type' => FuelType::AI_95
        ];

        $repository = app(UserVehicleRepository::class);
        $userVehicle = $repository->create($user, $userVehicleData);

        $this->assertInstanceOf(UserVehicle::class, $userVehicle);
        $this->assertEquals($user->id, $userVehicle->user_id);
        $this->assertEquals($userVehicleData['vehicle_id'], $userVehicle->vehicle_id);
        $this->assertEquals($userVehicleData['model_id'], $userVehicle->model_id);
        $this->assertEquals($userVehicleData['manufacture_year'], $userVehicle->manufacture_year);
        $this->assertEquals($userVehicleData['vin'], $userVehicle->vin);
        $this->assertEquals($userVehicleData['mileage'], $userVehicle->mileage);
        $this->assertEquals($userVehicleData['power'], $userVehicle->power);
        $this->assertEquals($userVehicleData['purchase_date']->format('Y-m-d'), $userVehicle->purchase_date->format('Y-m-d'));
        $this->assertEquals($userVehicleData['fuel_type'], $userVehicle->fuel_type);
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
            $userVehicleData = [
                'vehicle_id' => $vehicle->id,
                'model_id' => $models[0]['id'],
                'manufacture_year' => rand($models[0]['year_from'], $models[0]['year_to']),
                'vin' => Str::random(17),
                'mileage' => rand(20_000, 200_000),
                'power' => rand(100, 300),
                'purchase_date' => now()->subYears(rand (1, 3)),
                'fuel_type' => FuelType::AI_95
            ];

            $repository = app(UserVehicleRepository::class);
            $userVehicle = $repository->create($user, $userVehicleData);
        }


        $repository = app(UserVehicleRepository::class);
        $result = $repository->findAll($user->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
    }
}
