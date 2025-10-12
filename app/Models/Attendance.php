<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property int $id
 * @property int $user_id
 * @property int $schedule_id
 * @property boolean $is_present
 * @property string $reason
 * @property boolean $reasonable
 * @property int $passed_hours
 *
 * @property-read Schedule $schedule_day
 * @property-read User $user
 */
class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'schedule_id',
        'is_present',
        'reason',
        'reasonable',
        'passed_hours',
    ];

    /**
     * @return HasOne
     */
    public function schedule_day(): HasOne
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
