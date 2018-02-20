<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LongTimeWithoutLogin;
use App\Student;
class LookForInactiveStudents implements ShouldQueue
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
        Log::info('Looking for inactive Students...');
        $students = Student::all();
        $inactiveStudents = array();
        foreach ($students as $student)
        {
            $daysSinceLastLoginCheck = ((time() - strtotime($student->extra()->first()->lastActivityCheckDate))/(60*60*24));
            Log::info($daysSinceLastLoginCheck);
            if($daysSinceLastLoginCheck > 5)
            {
                if($student->daysSinceLogin() > 5)
                {
                    array_push(
                        $inactiveStudents,
                        [
                            "student_id" => $student->id,
                            "email_type" => "inactivityEmail", 
                            "created_at" => date("Y-m-d H:i:s")
                        ]
                    );
                }
            }
            $student->extra()->update(["lastActivityCheckDate" => date("Y-m-d")]);
        }
        foreach(array_chunk($inactiveStudents,500) as $inactiveStudentsChunk)
        {
            DB::table('emails_queue')->insert($inactiveStudentsChunk);
        }

 
    }
}
