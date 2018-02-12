<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExtras extends Model
{
  public $timestamps = false;
  protected $table = 'students_extras';

  public function student()
  {
    return $this->belongsTo('App\Student');
  }
    //
}
