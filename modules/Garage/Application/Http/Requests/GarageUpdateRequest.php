<?php

declare(strict_types=1);

namespace Modules\Garage\Application\Http\Requests;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Modules\Garage\Domain\Rules\IsCurrentMileageMoreThenInitialRule;
use Modules\User\Domain\Models\User;
use Modules\User\Domain\Rules\IsVehicleBelongsToUserRule;

class GarageUpdateRequest extends FormRequest
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
            'vehicle_id' => ['required', 'integer', Rule::exists('vehicles', 'id'), new IsVehicleBelongsToUserRule($this->getCurrentUser()->id)],
            'model_id' => ['required', 'string'],
            'manufacture_year' => ['required', 'integer'],
            'vin' => ['nullable', 'string'],
            'initial_mileage' => ['required', 'integer'],
            'current_mileage' => ['required', 'integer', new IsCurrentMileageMoreThenInitialRule((int)$this->initial_mileage)],
            'power' => ['required', 'integer'],
            'purchase_date' => ['required', 'date'],
            'fuel_type' => ['required', 'integer'],
            'is_default' => ['required', 'boolean'],
        ];
    }

    /**
     * @param string $guard
     * @return User
     * @throws AuthenticationException
     */
    public function getCurrentUser(string $guard = 'sanctum'): User
    {
        $user = $this->user($guard);
        if (!$user) {
            throw new AuthenticationException();
        }
        return $user;
    }


    /**
     * Get the validated data from the request.
     *
     * @param array<array-key, mixed>|int|string|null $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null): mixed
    {
        $validated = parent::validated($key, $default);
        if (is_array($validated) && isset($validated['mileage'])) {
            $validated['initial_mileage'] = $validated['mileage'];
            $validated['current_mileage'] = $validated['mileage'];
            unset($validated['mileage']);
        }
        return $validated;
    }
}
