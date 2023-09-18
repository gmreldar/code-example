<?php

declare(strict_types=1);

namespace Modules\Authorization\Application\Http\Controllers\Api\V1;

use App\Exceptions\UnauthorizedHttpException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Authorization\Application\Http\Requests\LoginRequest;
use Modules\Authorization\Application\Http\Resources\AuthorizationResource;
use Modules\User\Domain\Models\User;

class AuthorizationController extends Controller
{
    /**
     * @throws UnauthorizedHttpException
     */
    public function login(LoginRequest $request): AuthorizationResource
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw new UnauthorizedHttpException();
        }
        /*** @var User $user */
        $user = $request->user();
        $user->token = $user->createToken(config('authorization.token_name'))->plainTextToken;

        return new AuthorizationResource($user);
    }
}
