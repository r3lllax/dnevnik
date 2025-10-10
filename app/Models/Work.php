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
 */
class Work extends Model
{
    protected $fillable = [
        'theme',
        'date',
    ];

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

}
