<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $comment
 * @property string $date
 * @property string $highlight
 *
 * @property-read Subject $subject
 * @property-read Group $group
 * @property-read Subject_time $time
 * @property-read User $teacher
 * @property-read Room $room
 * @property-read Semester $semester
 * @property-read Attendance[] $attendance
 */
class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = [
        'comment',
        'date',
        'highlight',
    ];

    /**
     * @return HasOne
     */
    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    /**
     * @return HasOne
     */
    public function group(): HasOne
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    /**
     * @return HasOne
     */
    public function time(): HasOne
    {
        return $this->hasOne(Subject_time::class, 'id', 'time_id');
    }

    /**
     * @return HasOne
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    /**
     * @return HasOne
     */
    public function room(): HasOne
    {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }

    /**
     * @return HasOne
     */
    public function semester(): HasOne
    {
        return $this->hasOne(Semester::class, 'id', 'semester_id');
    }

    /**
     * @return HasMany
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'schedule_id', 'id');
    }
}
