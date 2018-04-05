<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Encourege;
use App\Mail\Felicitate;
use App\Student;
class EvaluateStudentProgress implements ShouldQueue
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
        $students = Student::all();
        foreach ($students as $student) {
            if($student->progressSinceLastWeek() == -1)
            {
                Log::info('Sending New Module email to '.$student->name);
                Mail::to($student->email)->send(new NewModule($student));
            }
            if($student->progressSinceLastWeek() >= 10)
            {
                Log::info('Sending felicitation email to '.$student->name);
                Mail::to($student->email)->send(new Felicitate($student));
            }
            else
            {
                if($student->progressSinceLastWeek() >= 1 && $student->progressSinceLastWeek() < 10) {
                    Log::info('Sending Encourege email to '.$student->name);
                    Mail::to($student->email)->send(new Encourege($student));
                }
                else {
                    Log::info('Sending No Progress Email email to '.$student->name);
                    Mail::to($student->email)->send(new NoProgress($student));
                }
            }
        }

    }
}
