<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Position
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ElectionType[] $electionType
 * @property-read int|null $election_type_count
 *
 * @method static Builder|Position cdsgElection()
 * @method static Builder|Position dsgElection()
 * @method static Builder|Position newModelQuery()
 * @method static Builder|Position newQuery()
 * @method static Builder|Position ofElectionType(\App\Models\ElectionType $electionType)
 * @method static Builder|Position query()
 * @method static Builder|Position whereId($value)
 * @method static Builder|Position whereName($value)
 *
 * @mixin \Eloquent
 */
class Position extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function electionType(): BelongsToMany
    {
        return $this->belongsToMany(ElectionType::class);
    }

    public function scopeCdsgElection(Builder $query)
    {
        $query->whereRelation('electionType', 'id', ElectionType::TYPE_CDSG)
            ->orderBy('id');
    }

    public function scopeDsgElection(Builder $query)
    {
        $query->whereRelation('electionType', 'id', ElectionType::TYPE_DSG)
            ->orderBy('id');
    }

    public function scopeOfElectionType(Builder $query, ElectionType $electionType)
    {
        $query->whereRelation('electionType', 'id', $electionType->id)
            ->orderBy('id');
    }
}
