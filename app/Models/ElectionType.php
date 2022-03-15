<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ElectionType extends Model
{
    use HasFactory;

    public const DSG = 1;
    public const CDSG = 2;

    protected $guarded = [
        'name',
        'description'
    ];

    public function elections()
    {
        return $this->hasMany(Election::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }
}
