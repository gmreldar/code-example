<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\Application\Http\Controllers\Api\V1;

use Modules\User\Domain\Models\User;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $loginData = [
            'email' => $user->email,
            'password' => 'q1w2e3r4'
        ];
        $response = $this->postJson('/api/v1/login', $loginData);
        /** @phpstan-ignore-next-line  */
        $token = $response->getData()->data->token;

        $response = $this->getJson('/api/v1/vehicles', [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'cyrillic_name',
                    'is_popular',
                    'country',
                    'models',
                ],
            ],
        ]);
    }

    public function testIndexUnauthorized(): void
    {
        $response = $this->getJson('/api/v1/vehicles', [
            'Authorization' => 'Bearer' . 'adsfadsfadsfsdf',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.',
        ]);
    }
}
