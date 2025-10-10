<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property int $id
 * @property string $name
 *
 * @property-read User[] $users
 * @property-read Subject[] $subjects
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

    /**
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class,'groups_subjects','group_id','subject_id');
    }
}
