<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
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
}
