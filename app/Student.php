<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
    ];
    public function getFirstNameAttribute($value) {
        $sepPos = strpos($this ->name,",");
        $firstName = trim(substr($this->name,$sepPos+1)); 
        return ucfirst(strtolower($firstName));
    }
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

    private function progressDifference($progressLater, $progressOlder) {
        return $progressLater->current_number_of_topics_learned - $progressOlder->current_number_of_topics_learned;
    }
    public function progressSinceLastWeek() {
        $studentCurrentProgress = $this->moduleProgressions()->latest()->first();
        $studentPreviousWeekProgress = $this->moduleProgressions()
            ->where([
                ['prep_and_learning_module','=',$studentCurrentProgress->prep_and_learning_module],
                ['created_at','<=',date('Y-m-d',strtotime('-6 days',strtotime($studentCurrentProgress->created_at)))],
	])
            ->latest()
            ->first();
        if($studentPreviousWeekProgress === null)
            return -1;
        return $this->progressDifference($studentCurrentProgress,$studentPreviousWeekProgress);

    }
}
