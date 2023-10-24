<?php

declare(strict_types=1);

namespace Modules\Garage\Tests\Feature\Application\Http\Controllers\Api\V1\GarageControllerTest;

use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;
use Tests\Feature\Traits\UserAuthorizationTestTrait;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use UserAuthorizationTestTrait;

    public function testAdd(): void
    {
        $token = $this->getToken(584);
        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        /*** @var $vehicle Vehicle */
        $vehicle = Vehicle::inRandomOrder()->first();
        $models = $vehicle?->models;
        if (!$models) {
            throw new RecordsNotFoundException("Models nof found");
        }
        $data = [
            'vehicle_id' => $vehicle->id,
            'model_id' => $models[0]['id'],
            'manufacture_year' => rand($models[0]['year_from'], $models[0]['year_to']),
            'vin' => Str::random(17),
            'mileage' => rand(20_000, 200_000),
            'power' => rand(100, 300),
            'purchase_date' => now()->subYears(rand (1, 3)),
            'fuel_type' => FuelType::AI_95
        ];
        $response = $this->postJson('/api/v1/user/garages', $data, $headers);
        $response->assertStatus(204);
    }

    public function testAddUnauthorized(): void
    {
        $headers = [
            'Authorization' => 'Bearer asdfadsfsf',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        /*** @var $vehicle Vehicle */
        $vehicle = Vehicle::inRandomOrder()->first();
        $models = $vehicle?->models;
        if (!$models) {
            throw new RecordsNotFoundException("Models nof found");
        }
        $data = [
            'vehicle_id' => $vehicle->id,
            'model_id' => $models[0]['id'],
            'manufacture_year' => rand($models[0]['year_from'], $models[0]['year_to']),
            'vin' => Str::random(17),
            'mileage' => rand(20_000, 200_000),
            'power' => rand(100, 300),
            'purchase_date' => now()->subYears(rand (1, 3)),
            'fuel_type' => FuelType::AI_95
        ];
        $response = $this->postJson('/api/v1/user/garages', $data, $headers);

        $response->assertStatus(401);

        $this->assertFalse(Auth::check());

        $response->assertJsonFragment([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function testAddValidationFailed(): void
    {
        $token = $this->getToken();
        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $data = [];
        $response = $this->postJson('/api/v1/user/garages', $data, $headers);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'vehicle_id',
                'model_id',
                'manufacture_year',
                'mileage',
                'power',
                'purchase_date',
                'fuel_type'
            ]);
    }
}
