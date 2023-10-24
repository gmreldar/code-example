<?php

declare(strict_types=1);

namespace Modules\Garage\Tests\Feature\Application\Http\Controllers\Api\V1\GarageControllerTest;

use Modules\Garage\Domain\Models\Garage;
use Modules\User\Domain\Models\User;
use Tests\Feature\Traits\UserAuthorizationTestTrait;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use UserAuthorizationTestTrait;

    public function testDelete(): void
    {
        $user = User::factory()->create();

        /*** @var Garage $vehicle */
        $vehicle = Garage::factory()->create([
            'user_id' => $user->id,
            'is_default' => true
        ]);
        $token = $this->getToken($user->id);
        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $response = $this->deleteJson("/api/v1/user/garages/{$vehicle->id}", $headers);
        $response->assertStatus(204);
        $vehicle = Garage::find($vehicle->id);

        $this->assertNull($vehicle);
    }
}
