<?php

namespace App\Models;

use App\Enums\AgentJobTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Agent
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @package App\Models
 */
class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
    ];

    public function properties(?AgentJobTypeEnum $type = null, bool $withPivot = false): BelongsToMany
    {
        $query = $relation = $this->belongsToMany(Agent::class, 'agents_properties');

        if ($type || $withPivot) {
            $query->withPivot('job_type');
        }

        if ($type) {
            $query->wherePivot('job_type', $type);
        }

        return $query;
    }

    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function selling(): BelongsToMany
    {
        return $this->properties(AgentJobTypeEnum::Selling(), true);
    }

    public function viewing(): BelongsToMany
    {
        return $this->properties(AgentJobTypeEnum::Viewing(), true);
    }
}
