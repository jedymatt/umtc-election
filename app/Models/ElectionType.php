<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ElectionType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Election[] $elections
 * @property-read int|null $elections_count
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereName($value)
 * @mixin \Eloquent
 */
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
