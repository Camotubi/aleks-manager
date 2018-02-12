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
class SendEmailToInactiveStudents implements ShouldQueue
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
        Log::info('Looking for Students to Felicitate...');
        $students = Student::all();
        $inactiveStudents = collect();
        foreach ($students as $student)
        {
            $daysSinceLogin = (time() - strtotime($student->lastLogin()))/(60*60*24);
            if($daysSinceLogin > 5)
            {
                Log::info('Sending email to student '. $student->name.'. Reason: '.$daysSinceLogin.' days without login in.');
                Mail::to($student->email)->send(new LongTimeWithoutLogin($student));
                //$inactiveStudents->push($student);
            }
        }
 
    }
}
