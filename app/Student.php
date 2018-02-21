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

    public function isFelicitable() {
      if($this->moduleProgressions()->latest()->first()->current_number_of_topics_learned_per_hour >= 2.5)
        return true;
      else
        return false;
    }

    public function isAdjudicable() {
      return !$this->isFelicitable();
    }

    public function daysSinceLogin()
    {
                return (time() - strtotime($this->lastLogin()))/(60*60*24);
    }
}
