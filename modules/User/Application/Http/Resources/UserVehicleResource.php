<?php

declare(strict_types=1);

namespace Modules\User\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Domain\Models\UserVehicle;

/**
 * @property UserVehicle $resource
 */
class UserVehicleResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'vehicle_id' => $this->resource->vehicle_id,
            'vehicle' => [
                'id' => $this->resource->vehicle->id,
                'name' => $this->resource->vehicle->name,
                'cyrillic_name' => $this->resource->vehicle->cyrillic_name,
                'country' => $this->resource->vehicle->country,
                'model' => $this->resource->vehicle->getModelById($this->resource->model_id)
            ],
            'manufacture_year' => $this->resource->manufacture_year,
            'vin' => $this->resource->vin,
            'mileage' => $this->resource->mileage,
            'power' => $this->resource->power,
            'purchase_date' => $this->resource->purchase_date,
            'fuel_type' => $this->resource->fuel_type,
        ];
    }
}
