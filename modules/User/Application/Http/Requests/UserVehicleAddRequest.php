<?php

declare(strict_types=1);

namespace Modules\User\Application\Http\Requests;

use App\Exceptions\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Modules\User\Domain\Models\User;

class UserVehicleAddRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer', Rule::exists('vehicles', 'id')],
            'model_id' => ['required', 'string'],
            'manufacture_year' => ['required', 'integer'],
            'vin' => ['nullable', 'string'],
            'mileage' => ['required', 'integer'],
            'power' => ['required', 'integer'],
            'purchase_date' => ['required', 'date'],
            'fuel_type' => ['required', 'integer'],
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
}
