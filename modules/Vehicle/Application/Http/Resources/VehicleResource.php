<?php

declare(strict_types=1);

namespace Modules\Vehicle\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vehicle\Domain\Models\Vehicle;

/**
 * @property Vehicle $resource
 */
class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'cyrillic_name' => $this->resource->cyrillic_name,
            'is_popular' => $this->resource->is_popular,
            'country' => $this->resource->country,
            'models' => $this->resource->models,
        ];
    }
}
