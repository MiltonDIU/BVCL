<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];


    public function training(){
        return $this->belongsToMany('App\Models\Allocation')->withPivot(['begin_time','close_time']);
    }
}
