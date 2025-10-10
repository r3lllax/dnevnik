<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $grade
 * @property string $comment
 * @property string $date
 *
 * @property-read Work $work
 * @property-read Subject $subject
 * @property-read User $user
 */
class Grade extends Model
{
    protected $fillable = [
        'grade',
        'comment',
        'date',
        'subject_id',
        'work_id',
        'semester_id',
    ];

    public $timestamps = false;

    /**
     * work
     * @return HasOne
     */
    public function work(): HasOne
    {
        return $this->hasOne(Work::class,'id','work_id');
    }

    /**
     * subject
     * @return HasOne
     */
    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    /**
     * User
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
