<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

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

    public function scopeDoesntHaveDsgElectionOfEvent(EloquentBuilder $query, Event $event)
    {
        return $query->whereNotExists(function (QueryBuilder $query) use ($event) {
            $query->select()
                ->from('elections')
                ->whereColumn('department_id', '=', 'departments.id')
                ->where('election_type_id', '=', ElectionType::TYPE_DSG)
                ->where('event_id', '=', $event->id)
                ->whereNotNull('department_id');
        });
    }
}
