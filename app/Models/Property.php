<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\AgentJobTypeEnum;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Property
 *
 * @property int $id
 * @property string $remote_uuid
 * @property string $county
 * @property string $country
 * @property string $town
 * @property string $description
 * @property string $address
 * @property string $image_url
 * @property string $thumbnail_url
 * @property string $latitude
 * @property string $longitude
 * @property int $bedrooms
 * @property double $bathrooms
 * @property double $price
 * @property PropertyType $type
 * @property object $property_type
 * @property Collection $agents
 * @property Collection $sellers
 * @property Collection $viewers
 * @package App\Models
 */
class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'remote_uuid',
        'county',
        'country',
        'town',
        'description',
        'address',
        'image_url',
        'thumbnail_url',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'price',
        'type',
        'data_hash',
        'property_type',
    ];

    protected $casts = [
        'type' => PropertyType::class,
        'property_type' => Json::class,
        'price' => 'decimal:2'
    ];

    public function agents(AgentJobTypeEnum $type = null, bool $withPivot = false): BelongsToMany
    {
        $query = $this->belongsToMany(Agent::class, 'agents_properties');

        if ($type || $withPivot) {
            $query->withPivot('job_type');
        }

        if ($type) {
            $query->wherePivot('job_type', $type);
        }

        return $query;
    }

    public function sellers(): BelongsToMany
    {
        return $this->agents(AgentJobTypeEnum::Selling(), true);
    }

    public function viewers(): BelongsToMany
    {
        return $this->agents(AgentJobTypeEnum::Viewing(), true);
    }
}
