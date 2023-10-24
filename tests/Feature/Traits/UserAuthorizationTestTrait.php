<?php

declare(strict_types=1);

namespace Tests\Feature\Traits;

use Modules\User\Domain\Models\User;

trait UserAuthorizationTestTrait
{
    public function getToken(?int $userId = null): string
    {
        if (!$userId) {
            $user = User::factory()->create();
        } else {
            $user = User::find($userId);
        }
        $loginData = [
            'email' => $user->email,
            'password' => 'q1w2e3r4'
        ];
        $response = $this->postJson('/api/v1/login', $loginData);
        /** @phpstan-ignore-next-line  */
        return $response->getData()->data->token;
    }
}
