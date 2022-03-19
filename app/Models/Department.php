<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

    public function activeElections()
    {
        return $this->hasMany(Election::class)->active()->ofDepartment($this->id);
    }

    public function endedElections()
    {
        return $this->hasMany(Election::class)->ended()->ofDepartment($this->id);
    }

    public function endedDsgElections(): HasMany
    {
        return $this->hasMany(Election::class)
            ->where('end_at', '<', now())
            ->where('election_type_id', ElectionType::TYPE_DSG)
            ->whereNull('cdsg_id');
    }

}
