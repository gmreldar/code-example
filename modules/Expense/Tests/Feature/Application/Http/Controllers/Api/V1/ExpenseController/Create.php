<?php

declare(strict_types=1);

namespace Modules\Expense\Tests\Feature\Application\Http\Controllers\Api\V1\ExpenseController;

use Modules\User\Domain\Models\User;
use Modules\User\Domain\Models\UserVehicle;
use Tests\TestCase;

class Create
{
    public function testMissingRequiredFields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('POST', '/api/v1/expenses', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'user_id', 'user_vehicle_id', 'expense_category_id', 'amount', 'millage'
            ]);
    }

    public function testInvalidDataTypes(): void
    {
        $user = User::factory()->create();

        $invalidData = [
            'user_id' => 'st',
            'user_vehicle_id' => 'string',
            'expense_category_id' => 'string',
            'amount' => 'string',
            'millage' => 'string',
        ];

        $response = $this->actingAs($user)->json('POST', '/api/v1/expenses', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'user_id', 'user_vehicle_id', 'expense_category_id', 'amount', 'millage'
            ]);
    }

    public function testNonExistingUser(): void
    {
        $user = User::factory()->create();
        $nonExistingUserId = 9999; // Предположим, что такого пользователя нет

        $invalidData = [
            'user_id' => $nonExistingUserId,
            'user_vehicle_id' => 1, // Допустим, что это существующее транспортное средство пользователя
            'expense_category_id' => 1, // Допустим, что это существующая категория траты
            'amount' => 100.5,
            'millage' => 50000,
        ];

        $response = $this->actingAs($user)->json('POST', '/api/v1/expenses', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id']);
    }

    public function testInvalidDateFormats(): void
    {
        $user = User::factory()->create();

        $invalidData = [
            'user_id' => $user->id,
            'user_vehicle_id' => 1, // Допустим, что это существующее транспортное средство пользователя
            'expense_category_id' => 1, // Допустим, что это существующая категория траты
            'amount' => 100.5,
            'millage' => 50000,
            'scheduled_maintenance_at' => 'invalid-date-format', // Некорректный формат даты
            'completed_maintenance_at' => '2022-13-01', // Некорректная дата
        ];

        $response = $this->actingAs($user)->json('POST', '/api/v1/expenses', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_maintenance_at', 'completed_maintenance_at']);
    }

    public function testNegativeValues(): void
    {
        $user = User::factory()->create();
        $userVehicle = UserVehicle::factory()->create(['user_id' => $user->id]);

        $invalidData = [
            'user_id' => $user->id,
            'user_vehicle_id' => $userVehicle->id,
            'expense_category_id' => 1, // Допустим, что это существующая категория траты
            'amount' => -100.5, // Отрицательная сумма
            'millage' => -50000, // Отрицательный пробег
        ];

        $response = $this->actingAs($user)->json('POST', '/api/v1/expenses', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['amount', 'millage']);
    }
}
