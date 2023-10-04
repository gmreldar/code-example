<?php

declare(strict_types=1);

namespace Modules\Expense\Tests\Feature\Application\Http\Controllers\Api\V1;

use Tests\Feature\Traits\UserAuthorizationTestTrait;
use Tests\TestCase;

class ExpenseCategoryControllerTest extends TestCase
{
    use UserAuthorizationTestTrait;

    public function testIndex(): void
    {
        $token = $this->getToken();
        $headers = [
            'Authorization' => 'Bearer' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $response = $this->getJson('/api/v1/expenses/category', $headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    public function testIndexUnauthorized(): void
    {
        $response = $this->getJson('/api/v1/expenses/category', [
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
