<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use \DateTimeInterface;
use App\Notifications\VerifyUserNotification;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens, HasFactory;

    public $table = 'users';

    const IS_APPROVED = [
        '1' => 'Yes',
        '0' => 'No',
    ];
    const IS_VERIFIED = [
        '1' => 'Yes',
        '0' => 'No',
    ];
    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'verified_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'verified',
        'verified_at',
        'verification_token',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
        //return $this->roles()->whereIn('id', [2,1])->exists();// multiple roles check as a is_admin power
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified    = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token     = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token     = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');

                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }

//                $user->notify(new VerifyUserNotification($user));
            }
        });
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function userBusinesses()
    {
        return $this->hasMany(Business::class, 'user_id', 'id');
    }

    public function userServices()
    {
        return $this->hasMany(Service::class, 'user_id', 'id');
    }
    public function userAssessments()
    {
        return $this->hasMany(Assessment::class, 'user_id', 'id');
    }

    public function assignServices()
    {
        return $this->belongsToMany(Service::class);
    }

    public function userTrainings()
    {
        return $this->belongsToMany(Training::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'training_id', 'id');
    }

}
