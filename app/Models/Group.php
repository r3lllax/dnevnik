<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property int $id
 * @property string $name
 *
 * @property-read User[] $users
 */
class Group extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * group`s users(include teacher)
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
