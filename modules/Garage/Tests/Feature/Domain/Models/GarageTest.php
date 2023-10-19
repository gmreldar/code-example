<?php

declare(strict_types=1);

namespace Modules\Garage\Tests\Feature\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\RecordsNotFoundException;
use Modules\Garage\Domain\Models\Garage;
use Modules\User\Domain\Models\User;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;
use Tests\TestCase;

class GarageTest extends TestCase
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
        $garage = Garage::factory()->create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'manufacture_year' => 2022,
            'vin' => 'ABC123',
            'initial_mileage' => 10000,
            'current_mileage' => 10000,
            'power' => 200,
            'purchase_date' => now(),
            'fuel_type' => FuelType::DIESEL,
            'model_id' => 'XYZ123',
        ]);

        // Проверяем, что созданный экземпляр соответствует ожиданиям
        $this->assertInstanceOf(Garage::class, $garage);
        $this->assertEquals($user->id, $garage->user_id);
        $this->assertEquals($vehicle->id, $garage->vehicle_id);
        $this->assertEquals(2022, $garage->manufacture_year);
        $this->assertEquals('ABC123', $garage->vin);
        $this->assertEquals(10000, $garage->initial_mileage);
        $this->assertEquals(10000, $garage->current_mileage);
        $this->assertEquals(200, $garage->power);
        $this->assertInstanceOf(Carbon::class, $garage->purchase_date);
        $this->assertEquals(FuelType::DIESEL, $garage->fuel_type);
        $this->assertEquals('XYZ123', $garage->model_id);

        // Проверяем связи с пользователем и транспортным средством
        $this->assertInstanceOf(User::class, $garage->user);
        $this->assertInstanceOf(Vehicle::class, $garage->vehicle);
    }
}
