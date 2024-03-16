<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectionType extends Model
{
    use HasFactory;

    public const TYPE_DSG = 1;

    public const TYPE_CDSG = 2;

    public $timestamps = false;

    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

    public function isTypeDsg(): bool
    {
        return $this->type === self::TYPE_DSG;
    }
}
