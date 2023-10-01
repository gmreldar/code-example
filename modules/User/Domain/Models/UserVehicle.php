<?php

declare(strict_types=1);

namespace Modules\User\Domain\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\User\Infrastructure\Database\Factories\UserVehicleFactory;
use Modules\Vehicle\Domain\Models\Vehicle;
use Modules\Vehicle\Infrastructure\Enums\FuelType;



/**
 * Modules\User\Domain\Models\UserVehicle
 *
 * @property int $id
 * @property int $user_id
 * @property int $vehicle_id
 * @property int $manufacture_year
 * @property string|null $vin
 * @property int $mileage
 * @property int $power
 * @property Carbon $purchase_date
 * @property FuelType $fuel_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read Vehicle $vehicle
 * @method static Builder|UserVehicle newModelQuery()
 * @method static Builder|UserVehicle newQuery()
 * @method static Builder|UserVehicle query()
 * @method static Builder|UserVehicle whereCreatedAt($value)
 * @method static Builder|UserVehicle whereFuelType($value)
 * @method static Builder|UserVehicle whereId($value)
 * @method static Builder|UserVehicle whereManufactureYear($value)
 * @method static Builder|UserVehicle whereMileage($value)
 * @method static Builder|UserVehicle wherePower($value)
 * @method static Builder|UserVehicle wherePurchaseDate($value)
 * @method static Builder|UserVehicle whereUpdatedAt($value)
 * @method static Builder|UserVehicle whereUserId($value)
 * @method static Builder|UserVehicle whereVehicleId($value)
 * @method static Builder|UserVehicle whereVin($value)
 * @property string $model_id
 * @method static Builder|UserVehicle whereModelId($value)
 * @mixin \Eloquent
 */
class UserVehicle extends Model
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
        'mileage',
        'power',
        'purchase_date',
        'fuel_type',
        'model_id'
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
     * @return UserVehicleFactory
     */
    protected static function newFactory(): UserVehicleFactory
    {
        return new UserVehicleFactory();
    }
}
