<?php

namespace App\Models;

use App\Casts\Json;
use App\Enums\AgentJobTypeEnum;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'county',
        'country',
        'town',
        'description',
        'details_url',
        'displayable_address',
        'image_url',
        'thumbnail_url',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'price',
        'type',
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
