<?php

declare(strict_types=1);

namespace Modules\User\Application\Http\Controllers\Api\V1;

use App\Exceptions\UnauthorizedHttpException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Modules\User\Api\UserVehicleRepositoryInterface;
use Modules\User\Application\Http\Requests\UserVehicleAddRequest;
use Modules\User\Application\Http\Resources\UserVehicleResource;

/**
 * Авто пользователя
 */
class UserVehicleController extends Controller
{
    public function __construct(private readonly UserVehicleRepositoryInterface $userVehicleRepository)
    {
    }

    /**
     * Дабоавить авто пользователя
     *
     * @param UserVehicleAddRequest $request
     * @return UserVehicleResource
     * @throws UnauthorizedHttpException
     */
    public function add(UserVehicleAddRequest $request): UserVehicleResource
    {
        $user = $request->getCurrentUser();
        return new UserVehicleResource($this->userVehicleRepository->create($user, (array)$request->validated()));
    }
}
