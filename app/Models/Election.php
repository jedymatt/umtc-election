<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'election_type_id',
        'department_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function electionType()
    {
        return $this->belongsTo(ElectionType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function positions()
    {
        return $this->loadMissing('electionType')
            ->electionType->loadMissing('positions')
            ->positions();
    }

    /**
     * @return string
     */
    public function getElectionStatus()
    {
        if (now() > $this->end_at) {
            return 'Ended';
        } else if (now() >= $this->start_at) {
            return 'Ongoing';
        } else {
            return 'Not yet started';
        }
    }


}
