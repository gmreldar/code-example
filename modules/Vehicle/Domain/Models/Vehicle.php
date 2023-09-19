<?php

declare(strict_types=1);

namespace Modules\Vehicle\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\ObjectId;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property ObjectId $_id
 * @property int $id
 * @property string $name
 * @property string $cyrillic_name
 * @property boolean $is_popular
 * @property string $country
 * @property array $models
 */
class Vehicle extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'mongodb';

    /**
     * The collection associated with the model.
     *
     * @var string
     */
    protected $collection = 'vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
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
    ];
}
