<?php

declare(strict_types=1);

namespace Modules\Garage\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Garage\Infrastructure\Database\Factories\GarageFactory;
use Modules\User\Domain\Models\User;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;

/**
 * Modules\Garage\Domain\Models\Garage
 *
 * @property int $id
 * @property int $user_id ИД Пользователя
 * @property int $vehicle_id ИД Транспортного средства
 * @property string $model_id ИД Модели транспотного средства
 * @property bool $is_default Выбрано транспортное средство по умолчанию
 * @property int $manufacture_year Год производства
 * @property int $initial_mileage Пробег на момент добавления траспортного средства в гараж
 * @property int $current_mileage Текущий пробег на сегодняшний день
 * @property int $power Мощность
 * @property \Illuminate\Support\Carbon $purchase_date Дата покупки
 * @property FuelType $fuel_type Тип топлива
 * @property string|null $vin ВИН Транспортного средства
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @property-read Vehicle $vehicle
 * @method static \Modules\Garage\Infrastructure\Database\Factories\GarageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Garage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Garage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Garage query()
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereCurrentMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereFuelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereInitialMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereManufactureYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage wherePower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereVehicleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garage whereVin($value)
 * @mixin \Eloquent
 */
class Garage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'manufacture_year',
        'vin',
        'initial_mileage',
        'current_mileage',
        'power',
        'purchase_date',
        'fuel_type',
        'model_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'datetime',
        'fuel_type' => FuelType::class
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }


    /**
     * @return GarageFactory
     */
    protected static function newFactory(): GarageFactory
    {
        return new GarageFactory();
    }
}
