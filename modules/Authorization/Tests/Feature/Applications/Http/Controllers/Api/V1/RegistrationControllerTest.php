<?php

declare(strict_types=1);

namespace Modules\Authorization\Tests\Feature\Applications\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    public function testUserRegistration(): void
    {
        $email = uniqid() . '@example.com';
        $userData = [
            'name' => 'John Doe',
            'email' => $email,
            'password' => 'password',
        ];

        // Отправка POST-запроса на регистрацию
        $response = $this->postJson('/api/v1/register', $userData);

        // Проверка ответа: ожидаем HTTP-код 201 (Created)
        $response->assertStatus(201);

        // Проверка, что пользователь создан в базе данных
        $this->assertDatabaseHas('users', ['email' => $email]);

        // Проверка, что пользователь успешно аутентифицирован
        $this->assertTrue(Auth::check());

        // Проверка, что в ответе есть необходимые поля
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'token',
            ],
        ]);
    }

    public function testUserRegistrationFailure(): void
    {
        // Подготовка данных для запроса с неверными данными (например, без email)
        $email = uniqid() . '@example.com';
        $userData = [
            'name' => 'John Doe',
            'password' => 'password123',
        ];

        // Отправка POST-запроса на регистрацию с неверными данными
        $response = $this->postJson('/api/v1/register', $userData);

        // Проверка ответа: ожидаем HTTP-код 422 (Unprocessable Entity) для неверных данных
        $response->assertStatus(422);

        // Проверка, что пользователь не создан в базе данных
        $this->assertDatabaseMissing('users', ['email' => $email]);

        // Проверка, что пользователь не аутентифицирован
        $this->assertFalse(Auth::check());

        // Проверка, что в ответе есть сообщение об ошибке
        $response->assertJson([
            'errors' => [
                'email' => ['Поле email адрес обязательно.']
            ]
        ]);

        // Проверка, что токен не создан и пользователь не аутентифицирован
        $this->assertGuest();
    }
}
