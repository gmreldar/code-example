<?php

declare(strict_types=1);

namespace Modules\Garage\Application\Http\Requests;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

/**
 * @property int $id
 */
class GarageDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, Exists|string>>
     * @throws AuthenticationException
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('garages', 'id')],
        ];
    }

    /**
     * Объединить параметры с урла с post-параметрами
     *
     * @param array<mixed>|mixed|null $keys
     * @return array<mixed>
     */
    public function all($keys = null): array
    {
        $parameters = $this->route() ? $this->route()->parameters() : [];
        return array_replace_recursive(parent::all($keys), $parameters);
    }
}
