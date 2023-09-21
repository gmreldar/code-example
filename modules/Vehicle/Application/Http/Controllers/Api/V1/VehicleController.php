<?php

declare(strict_types=1);

namespace Modules\Vehicle\Application\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Vehicle\Api\VehicleRepositoryInterface;
use Modules\Vehicle\Application\Http\Resources\VehicleResource;

class VehicleController extends Controller
{
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {}

    /**
     * Найти все ТС
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return VehicleResource::collection($this->vehicleRepository->findAll());
    }
}
