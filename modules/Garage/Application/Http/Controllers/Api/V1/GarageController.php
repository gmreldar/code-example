<?php

declare(strict_types=1);

namespace Modules\Garage\Application\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Modules\Garage\Api\GarageRepositoryInterface;
use Modules\Garage\Application\Http\Requests\GarageCreateRequest;
use Modules\Garage\Application\Http\Requests\GarageDeleteRequest;
use Modules\Garage\Application\Http\Requests\GarageUpdateRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Contracts\Foundation\Application as ContractApplication;

class GarageController extends Controller
{
    public function __construct(readonly private GarageRepositoryInterface $garageRepository)
    {}

    /**
     * @param GarageCreateRequest $request
     * @return Application|Response|ContractApplication|ResponseFactory
     * @throws AuthenticationException
     */
    public function create(GarageCreateRequest $request): Application|Response|ContractApplication|ResponseFactory
    {
        $user = $request->getCurrentUser();
        $this->garageRepository->create($user, (array)$request->validated());
        return response(status: SymfonyResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param GarageUpdateRequest $request
     * @return Application|Response|ContractApplication|ResponseFactory
     */
    public function update(GarageUpdateRequest $request): Application|Response|ContractApplication|ResponseFactory
    {
        $this->garageRepository->update((array)$request->validated());
        return response(status: SymfonyResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param GarageDeleteRequest $request
     * @return Application|Response|ContractApplication|ResponseFactory
     * @throws \Exception
     */
    public function delete(GarageDeleteRequest $request): Application|Response|ContractApplication|ResponseFactory
    {
        $this->garageRepository->delete((int)$request->id);
        return response(status: SymfonyResponse::HTTP_NO_CONTENT);
    }
}
