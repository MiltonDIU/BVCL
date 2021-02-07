<?php

namespace App\Models;
use Auth;
use DB;
class Site
{
    public static function config(){
        $settings = Setting::find(1);
        return $settings;
    }
}





