<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $incrementing = false;
     protected $casts = [
        'id' => 'string',
    ];
    public function extra()
    {
      return $this->hasOne('App\StudentExtras');
    }
    public function loginLogs() {
        return $this->hasMany('App\LoginLog','student_id','id'); 
    }
    public function lastLogin() {
        $lastLogin =$this->loginLogs()->orderBy('date','desc')->first();
        if(!is_null($lastLogin)){
            return $lastLogin->date;
        }
        return null;
    }
    public function moduleProgressions() {
        return  $this->hasMany('App\ModuleProgression','student_id','id'); 
    }
}
