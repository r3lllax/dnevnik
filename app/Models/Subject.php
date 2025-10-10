<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 *
 * @property-read User $teacher
 * @property-read Grade[] $grades
 * @property-read Schedule[] $schedule
 * @property-read Group[] $groups
 */
class Subject extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Teacher of this subject
     * @return HasOne
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(User::class,'id','teacher_id');
    }

    /**
     * @return HasMany
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
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
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class,'groups_subjects','subject_id','group_id');
    }
}
