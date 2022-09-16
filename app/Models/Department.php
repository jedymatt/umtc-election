<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

    public function getAcronymName(): string
    {
        return preg_replace('/\b([A-Z])|./', '$1', $this->name);
    }

    public function scopeDoesntHaveDsgElectionOfEvent(Builder $query, Event $event)
    {
        return $query->whereNotIn('id', function (Builder $query) use ($event) {
            $query->select('department_id')
                ->from('elections')
                ->where('election_type_id', '=', ElectionType::TYPE_DSG)
                ->where('event_id', '=', $event->id);
        });
    }
}
