<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $value
 * @property string $comment
 * @property string $date
 */
class Grade extends Model
{
    protected $fillable = [
        'value',
        'comment',
        'date',
    ];

    /**
     * work
     * @return HasOne
     */
    public function work(): HasOne
    {
        return $this->hasOne(Work::class);
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
