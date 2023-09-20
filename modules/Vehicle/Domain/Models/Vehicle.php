<?php

declare(strict_types=1);

namespace Modules\Vehicle\Domain\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * \Modules\Vehicle\Domain\Models\Vehicle
 *
 * @property int $id
 * @property string $name
 * @property string $cyrillic_name
 * @property bool $is_popular
 * @property string $country
 * @property array $models
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Vehicle newModelQuery()
 * @method static Builder|Vehicle newQuery()
 * @method static Builder|Vehicle query()
 * @method static Builder|Vehicle whereCountry($value)
 * @method static Builder|Vehicle whereCreatedAt($value)
 * @method static Builder|Vehicle whereCyrillicName($value)
 * @method static Builder|Vehicle whereId($value)
 * @method static Builder|Vehicle whereIsPopular($value)
 * @method static Builder|Vehicle whereModels($value)
 * @method static Builder|Vehicle whereName($value)
 * @method static Builder|Vehicle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'cyrillic_name',
        'is_popular',
        'country',
        'models'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'popular' => 'boolean',
        'models' => 'array',
    ];
}
