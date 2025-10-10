<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $theme
 * @property string $date
 *
 * @property-read Work_type $type
 * @property-read Grade[] $grades
 * @property-read Subject $subject
 */
class Work extends Model
{
    protected $fillable = [
        'theme',
        'date',
        'subject_id',
        'type_id',
    ];

    public $timestamps = false;
    /**
     * type of this work
     * @return HasOne
     */
    public function type(): HasOne
    {
        return $this->hasOne(Work_type::class,'id','type_id');
    }

    /**
     * @return HasMany
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * @return HasOne
     */
    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class,'id','subject_id');
    }

}
