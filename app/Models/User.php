<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $phone_number
 * @property int $role_id
 * @property string $email
 * @property string $login
 * @property string $password
 * @property string $birth_date
 * @property string $img_path
 *
 * @property-read Group $group
 * @property-read Grade[] $grades
 * @property-read string $initials
 * @property-read Role $role
 * @property-read Subject[] $subjects
 * @property-read Attendance[] $attendance
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'phone_number',
        'email',
        'login',
        'password',
        'birth_date',
        'img_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * returns initials of user, format Surname N.P.
     * @return string
     */
    public function initials(): string
    {
        return  mb_ucfirst($this->surname).' '.mb_ucfirst($this->name).' '.mb_ucfirst($this->patronymic);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * user`s group
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * role of user
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Role::class,'id','role_id');
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
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class,'teacher_id','id');
    }

    /**
     * @return HasMany
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class,'user_id','id');
    }

}
