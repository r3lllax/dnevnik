<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 */
class Subject_time extends Model
{
    protected $table = 'subjects_times';
    protected $fillable = [
        'start_time',
        'end_time',
    ];

    /**
     * @return HasMany
     */
    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class, 'time_id','id');
    }

}
