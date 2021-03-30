<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class TrainingApply extends Model
{
    use  HasFactory;

    public $table = 'training_applies';

    const IS_STATUS_SELECT = [
        '1' => 'Approved',
        '0' => 'Canceled',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'training_id',
        'user_id',
        'is_status',
        'who_give_permission',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public static function whoApproved($id){
        $user = User::find($id);
        return $user->name;
    }
}
