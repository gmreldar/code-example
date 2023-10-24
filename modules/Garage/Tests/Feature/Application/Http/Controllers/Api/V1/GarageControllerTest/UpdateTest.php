<?php

declare(strict_types=1);

namespace Modules\Garage\Tests\Feature\Application\Http\Controllers\Api\V1\GarageControllerTest;

use Illuminate\Support\Facades\Auth;
use Modules\Garage\Domain\Models\Garage;
use Modules\User\Domain\Models\User;
use Tests\Feature\Traits\UserAuthorizationTestTrait;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use UserAuthorizationTestTrait;

    public function testUpdate(): void
    {
        /** @var Garage $garage */
        $garage = Garage::inRandomOrder()->first();
        $isDefault = $garage->is_default;
        $initialMileage = rand(10_000, 90_000);
        $currentMileage = $initialMileage + rand(10_000, 50_000);

        $token = $this->getToken($garage->user_id);
        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $data = $garage->toArray();
        $data['is_default'] = !$isDefault;
        $data['initial_mileage'] = $initialMileage;
        $data['current_mileage'] = $currentMileage;

        $response = $this->putJson('/api/v1/user/garages', $data, $headers);
        $response->assertStatus(204);

        $garage->refresh();

        $this->assertEquals(!$isDefault, $garage->is_default, "Field 'is_default' did not update correctly.");
        $this->assertEquals($initialMileage, $garage->initial_mileage, "Field 'initial_mileage' did not update correctly.");
        $this->assertEquals($currentMileage, $garage->current_mileage, "Field 'current_mileage' did not update correctly.");
    }

    public function testAddUnauthorized(): void
    {
        /** @var Garage $garage */
        $garage = Garage::inRandomOrder()->first();
        $isDefault = $garage->is_default;
        $initialMileage = rand(10_000, 90_000);
        $currentMileage = $initialMileage + rand(10_000, 50_000);

        $headers = [
            'Authorization' => 'Bearer asdfadf',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $data = $garage->toArray();
        $data['is_default'] = !$isDefault;
        $data['initial_mileage'] = $initialMileage;
        $data['current_mileage'] = $currentMileage;

        $response = $this->putJson('/api/v1/user/garages', $data, $headers);

        $response->assertStatus(401);

        $this->assertFalse(Auth::check());

        $response->assertJsonFragment([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function testAddValidationFailed(): void
    {
        /** @var Garage $garage */
        $garage = Garage::inRandomOrder()->first();
        $token = $this->getToken($garage->user_id);

        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $data = [];
        $response = $this->putJson('/api/v1/user/garages', $data, $headers);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'vehicle_id',
                'model_id',
                'manufacture_year',
                'current_mileage',
                'initial_mileage',
                'power',
                'purchase_date',
                'fuel_type',
            ]);
    }

    /**
     * Тест на проверку корретного изменения поля is_default мне его обновлении
     * @return void
     */
    public function testChangeIsDefaultIfUserHasSeveralVehicles()
    {
        $user = User::factory()->create();

        /*** @var Garage $oldVehicle */
        $oldVehicle = Garage::factory()->create([
            'user_id' => $user->id,
            'is_default' => true
        ]);

        /*** @var Garage $newVehicle */
        $newVehicle = Garage::factory()->create([
            'user_id' => $user->id,
            'is_default' => false
        ]);

        $data = $newVehicle->toArray();
        $data['is_default'] = true;

        $token = $this->getToken($user->id);
        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $response = $this->putJson('/api/v1/user/garages', $data, $headers);

        $response->assertStatus(204);

        $oldVehicle->refresh();
        $newVehicle->refresh();
        $this->assertEquals(false, $oldVehicle->is_default);
        $this->assertEquals(true, $newVehicle->is_default);
    }
}
