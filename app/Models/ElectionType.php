<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ElectionType extends Model
{
    use HasFactory;

    public const TYPE_DSG = 1;

    public const TYPE_CDSG = 2;

    public $timestamps = false;

    protected $guarded = [
        'name',
        'description',
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
