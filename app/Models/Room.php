<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class Room extends Model
{
    protected $fillable = [
      'name',
    ];

    /**
     * @return HasMany
     */
    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
