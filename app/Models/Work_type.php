<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 *
 * @property-read Work[] $works
 */
class Work_type extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * works with this type
     * @return HasMany
     */
    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}
