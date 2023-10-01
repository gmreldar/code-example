<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Domain\Models;

use Illuminate\Database\RecordsNotFoundException;
use Modules\User\Domain\Models\User;
use Modules\User\Domain\Models\UserVehicle;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;
use Tests\TestCase;

class UserVehicleTest extends TestCase
{
    public function testUserVehicleModel(): void
    {
        // Создаем пользователя
        $user = User::factory()->create();

        // Создаем транспортное средство
        /*** @var $vehicle Vehicle */
        $vehicle = Vehicle::inRandomOrder()->first();
        if (!$vehicle) {
            throw new RecordsNotFoundException("Models nof found");
        }

        // Создаем тестовый экземпляр UserVehicle
        $userVehicle = UserVehicle::factory()->create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'manufacture_year' => 2022,
            'vin' => 'ABC123',
            'mileage' => 10000,
            'power' => 200,
            'purchase_date' => now(),
            'fuel_type' => FuelType::DIESEL,
            'model_id' => 'XYZ123',
        ]);

        // Проверяем, что созданный экземпляр соответствует ожиданиям
        $this->assertInstanceOf(UserVehicle::class, $userVehicle);
        $this->assertEquals($user->id, $userVehicle->user_id);
        $this->assertEquals($vehicle->id, $userVehicle->vehicle_id);
        $this->assertEquals(2022, $userVehicle->manufacture_year);
        $this->assertEquals('ABC123', $userVehicle->vin);
        $this->assertEquals(10000, $userVehicle->mileage);
        $this->assertEquals(200, $userVehicle->power);
        $this->assertInstanceOf(\Carbon\Carbon::class, $userVehicle->purchase_date);
        $this->assertEquals(FuelType::DIESEL, $userVehicle->fuel_type);
        $this->assertEquals('XYZ123', $userVehicle->model_id);

        // Проверяем связи с пользователем и транспортным средством
        $this->assertInstanceOf(User::class, $userVehicle->user);
        $this->assertInstanceOf(Vehicle::class, $userVehicle->vehicle);
    }
}
