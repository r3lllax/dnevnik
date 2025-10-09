<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 *
 * @property-read User $teacher
 * @property-read Grade[] $grades
 * @property-read Schedule[] $schedule
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
}
