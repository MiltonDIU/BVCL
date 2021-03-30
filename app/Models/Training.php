<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class Training extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'trainings';

    protected $dates = [
        'start_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const IS_ACTIVE_SELECT = [
        '1' => 'Running',
        '2' => 'Upcoming',
        '3' => 'Completed',
        '4' => 'Canceled',
        '0' => 'Inactive',
    ];

    protected $fillable = [
        'is_active',
        'title',
        'description',
        'duration',
        'start_date',
        'end_date',
        'outcome',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getScheduleAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setScheduleAttribute($value)
    {
        $this->attributes['schedule'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function days(){
//        return $this->belongsToMany(Day::class)->withPivot(['begin_time','close_time']);
        return $this->belongsToMany('App\Models\Day')->withPivot(['begin_time','close_time']);
    }

    public function apply(){
        return $this->hasMany(TrainingApply::class);
    }

    public function trainingTrainingApplies()
    {
        return $this->hasMany(TrainingApply::class, 'training_id', 'id');
    }


    public static function isApplied($training_id,$user_id){
        $applies = TrainingApply::where('user_id',$user_id)->where('training_id',$training_id)->first();
        if ($applies!=null){
            return true;
        }else{
            return false;
        }
    }


    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'training_id', 'id');
    }
    public static function checkAttendance($training_id,$user_id,$date)
    {
       $event = Attendance::where('training_id',$training_id)->where('user_id',$user_id)->where('event_date',$date)->first();
        if ($event!=null){
            return true;
        }else{
            return false;
        }
    }

}
