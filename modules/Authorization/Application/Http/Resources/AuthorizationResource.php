<?php

declare(strict_types=1);

namespace Modules\Authorization\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Domain\Models\User;

/**
 * @property User $resource
 */
class AuthorizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'token' => $this->resource->token,
        ];
    }
}
