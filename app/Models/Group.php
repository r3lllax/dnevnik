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

    /**
     * @return HasMany
     */
    public function group_lessons(): HasMany
    {
        return $this->hasMany(Group_Subject::class, 'group_id','id');
    }

    /**
     * @return HasMany
     */
    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
