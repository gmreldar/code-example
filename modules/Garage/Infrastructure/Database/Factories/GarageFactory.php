<?php

declare(strict_types=1);

namespace Modules\Garage\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Str;
use Modules\Garage\Domain\Models\Garage;
use Modules\User\Domain\Models\User;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;

class GarageFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Garage>
     */
    protected $model = Garage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /*** @var $vehicle Vehicle */
        $vehicle = Vehicle::inRandomOrder()->first();
        $models = $vehicle?->models;
        if (!$models) {
            throw new RecordsNotFoundException("Models nof found");
        }
        $mileage = rand(20_000, 200_000);
        return [
            'user_id' => User::factory(),
            'vehicle_id' => $vehicle->id,
            'manufacture_year' => rand($models[0]['year_from'], $models[0]['year_to']),
            'vin' => Str::random(17),
            'initial_mileage' => $mileage,
            'current_mileage' => $mileage,
            'power' => rand(100, 300),
            'purchase_date' => now()->subYears(rand (1, 3)),
            'fuel_type' => FuelType::AI_95,
            'model_id' => $models[0]['id']
        ];
    }
}
