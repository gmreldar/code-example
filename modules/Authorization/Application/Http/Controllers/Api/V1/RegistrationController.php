<?php

declare(strict_types=1);

namespace Modules\Authorization\Application\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Authorization\Application\Http\Requests\RegisterRequest;
use Modules\Authorization\Application\Http\Resources\AuthorizationResource;
use Modules\User\Domain\Models\User;

class RegistrationController extends Controller
{
    /**
     * Регистрация пользователя
     *
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): AuthorizationResource
    {
        /*** @var $user User */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw ValidationException::withMessages(['email' => 'Registration failed']);
        }
        $user->token = $user->createToken(config('authorization.token_name'))->plainTextToken;
        return new AuthorizationResource($user);
    }
}
