<?php

declare(strict_types=1);

namespace Modules\Authorization\Tests\Feature\Applications\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Modules\User\Domain\Models\User;
use Tests\TestCase;

class AuthorizationControllerTest extends TestCase
{
    public function testUserLogin(): void
    {
        // Создаем пользователя для теста
        $email = uniqid() . '@example.com';
        $user = User::create([
            'name' => 'John Doe',
            'email' => $email,
            'password' => bcrypt('password'),
        ]);

        // Подготавливаем данные для запроса
        $loginData = [
            'email' => $email,
            'password' => 'password',
        ];

        // Отправляем POST-запрос на авторизацию
        $response = $this->postJson('/api/v1/login', $loginData);

        // Проверяем успешный HTTP-статус (ожидаем 200 OK)
        $response->assertStatus(200);

        // Проверяем, что пользователь успешно аутентифицирован
        $this->assertTrue(Auth::check());

        // Проверяем, что в ответе есть необходимые поля
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'token',
            ],
        ]);
    }

    public function testUserLoginFailure(): void
    {
        // Подготавливаем данные для запроса с неверными данными
        $loginData = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ];

        // Отправляем POST-запрос на авторизацию с неверными данными
        $response = $this->postJson('/api/v1/login', $loginData);

        // Проверяем ошибку HTTP-статуса (ожидаем 401 Unauthorized)
        $response->assertStatus(401);

        // Проверяем, что пользователь не аутентифицирован
        $this->assertFalse(Auth::check());

        // Проверяем, что в ответе есть сообщение об ошибке
        $response->assertJsonFragment([
            'message' => 'Unauthorized.',
        ]);
    }
}
