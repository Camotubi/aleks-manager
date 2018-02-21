<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LongTimeWithoutLogin;
use App\Student;
class LookForStudentsToFelicitateOrEncourege implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Looking for Students to Felicitate or Encourege...');
        $students = Student::oldest();
        $students = Student::join('students_extras',
          'students_extras.student_id',
          '=',
          'students.id')
          ->oldest('lastActivityCheckDate')
          ->limit(100)
          ->get();
          foreach ($students as $student) {
            $daysSinceLastProgressCheck = (time() - strtotime($student->extra()->lastProgressCheckDate()))/(60*60*24); 
            if($daysSinceLastProgressCheck > 5)
            {
              Log::info('Sending email to student '. $student->name.'. Reason: '.$daysSinceLogin.' days without login in.');
              Mail::to($student->email)->send(new LongTimeWithoutLogin($student));
                //$inactiveStudents->push($student);
            }
        }
 
    }
}
