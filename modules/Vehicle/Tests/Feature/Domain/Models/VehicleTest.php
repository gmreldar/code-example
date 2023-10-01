<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\Domain\Models;

use Modules\Vehicle\Domain\Models\Vehicle;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    public function testVehicleModel(): void
    {
        // Создаем тестовый экземпляр Vehicle
        $vehicle = Vehicle::create([
            'name' => 'Test Vehicle',
            'cyrillic_name' => 'Тестовое ТС',
            'is_popular' => true,
            'country' => 'Test Country',
            'models' => [
                [
                    'id' => 'model_1',
                    'name' => 'Model 1',
                ],
                [
                    'id' => 'model_2',
                    'name' => 'Model 2',
                ],
            ],
        ]);

        // Проверяем, что созданный экземпляр соответствует ожиданиям
        $this->assertInstanceOf(Vehicle::class, $vehicle);
        $this->assertEquals('Test Vehicle', $vehicle->name);
        $this->assertEquals('Тестовое ТС', $vehicle->cyrillic_name);
        $this->assertTrue($vehicle->is_popular);
        $this->assertEquals('Test Country', $vehicle->country);
        $this->assertIsArray($vehicle->models);
        $this->assertCount(2, $vehicle->models);

        // Проверяем, что метод getModelById работает правильно
        $model = $vehicle->getModelById('model_1');
        $this->assertIsArray($model);
        $this->assertEquals('Model 1', $model['name']);

        // Проверяем, что метод getModelById возвращает пустой массив для несуществующего id
        $nonExistentModel = $vehicle->getModelById('non_existent_model');
        $this->assertEmpty($nonExistentModel);
        $vehicle->delete();
    }
}
