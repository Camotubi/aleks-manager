<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{

protected $table = 'aleks_logins';
    public function user()
    {
        return $this->belongsTo('App\User','student_id');
    }
}
