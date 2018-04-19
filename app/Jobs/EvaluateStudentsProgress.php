<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\Encourege;
use App\Mail\Felicitate;
use App\Mail\NewModule;
use App\Mail\NoProgress;
use App\Student;
use Carbon\Carbon;
class EvaluateStudentsProgress implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $timeout = 600;
	public $tries = 1;
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
		$students = Student::where('email_enabled',true)
			->whereHas('moduleProgressions',function($query){
				$query->latest()->where([
					['current_number_of_topics_learned','<',286],
					[function($query) {
						$query->latest()
							->where(DB::Raw('DATE_ADD(`students`.`created_at`, INTERVAL 6 MONTH)'),
								'>',
								Carbon::now());
					}]
				]);
			})->get(); 
		foreach ($students as $student) {
            Log::info('Evaluating Student with id:'. $student->id);
			if($student->progressSinceLastWeek() == -1)
			{
				Log::info('Sending New Module email to '.$student->name);
				Mail::to($student->email)->queue(new NewModule($student));
			}
			else {

				if($student->progressSinceLastWeek() >= 10)
				{
					Log::info('Sending felicitation email to '.$student->name);
					Mail::to($student->email)->queue(new Felicitate($student));
				}
				else
				{
					if($student->progressSinceLastWeek() >= 1 && $student->progressSinceLastWeek() < 10) {
						Log::info('Sending Encourege email to '.$student->name);
						Mail::to($student->email)->queue(new Encourege($student));
					}
					else {
						Log::info('Sending No Progress Email email to '.$student->name);
						Mail::to($student->email)->queue(new NoProgress($student));
					}
				}
			}
		}

	}
}
