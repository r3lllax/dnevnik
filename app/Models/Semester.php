<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $from
 * @property string $to
 *
 * @property-read Grade[] $grades
 * @property-read Schedule[] $schedule
 */
class Semester extends Model
{
    protected $fillable = [
        'name',
        'from',
        'to',
    ];

    /**
     * grades
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
     * Check month number in semester
     * @param int $month
     * @return bool
     */
    public function monthInSemester(int $month): bool
    {
        $from = Carbon::parse($this->from)->month;
        $to = Carbon::parse($this->to)->month;
        return ($month>=$from && $month<=$to)?true:false;
    }

}
