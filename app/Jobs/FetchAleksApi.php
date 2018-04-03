<?php

namespace App\Jobs;
use App\Student;
use App\Cohort;
use App\StudentExtras;
use App\LoginLog;
use App\PlacementResult;
use App\ModuleProgression;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchAleksApi implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$aleksUser = env('ALEKS_USER');
		$aleksPass = env('ALEKS_PASSWORD');
		$cohorts = Cohort::all();
		foreach($cohorts as $cohort)
		{
			$aleksUrl = "https://api.aleks.com/urlrpc?method=getPlacementReport&username={$aleksUser}&password={$aleksPass}&class_code={$cohort->class_code}&type=all&show_prep=true";
			$options = array(
				'http'=>array(
					'method'=>"GET",
					'header'=>"Accept-language: en\r\n" .
					"Cookie: foo=bar\r\n" .
					"User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" 
				)
			);
			$context = stream_context_create($options);
			$studentsPlacements = (new \parseCSV(file_get_contents($aleksUrl,false,stream_context_create($options))))->data;
			foreach($studentsPlacements as $studentPlacement)
			{
				$student = Student::find($studentPlacement["Student Id"]);	
				if(is_null($student))
				{

					$student = new Student();
					$student -> name = $studentPlacement["Name"];
					$student -> id = $studentPlacement["Student Id"];
					$student -> email = $studentPlacement["Email"];
					$student -> class_code = $cohort->class_code;
					$student->save();
					$student->extra()->save(new StudentExtras());
				}
				$studentLastProgress = $student->moduleProgressions()->latest()->first();
				if(
					is_null($studentLastProgress)
				       	||
					((strtotime(date("Y-m-d"))-strtotime($studentLastProgress->created_at))/(3600*24)>6)
				) {





					$loginLog = new LoginLog();
					$loginLog -> student_id = $student -> id;
					$loginLog -> date = date('Y-m-d', strtotime($studentPlacement["Last login"]));
					$loginLog -> save();
					$placementResult = new PlacementResult();
					$placementResult -> placement_assestment_number = $studentPlacement["Placement Assessment Number"];
					$placementResult -> total_number_of_placements_taken = $studentPlacement["Total Number of Placements Taken"]; 
					$placementResult -> start_date = date('Y-m-d', strtotime($studentPlacement["Start Date"]));
					$placementResult -> start_time = date('h:i:s', strtotime($studentPlacement["Start Time"]));
					$placementResult -> end_date = date('Y-m-d', strtotime($studentPlacement["End Date"]));
					$placementResult -> end_time = date('h:i:s', strtotime($studentPlacement["End Time"]));
					$placementResult -> proctored_assestment = $studentPlacement["Proctored Assessment"];
					$placementResult -> time_in_placements = $studentPlacement["Time in Placement (in hours)"];
					$placementResult -> placement_result = substr($studentPlacement["Placement Results %"],0,-1);
					$placementResult -> student_id = $student -> id;
					$placementResult -> save();
					$moduleProgression = new ModuleProgression();
					$moduleProgression -> student_id = $student -> id;
					$moduleProgression -> prep_and_learning_module = $studentPlacement["Prep and Learning Module"];
					$moduleProgression -> initial_mastery = is_numeric(substr($studentPlacement["Initial Mastery %"],0,-1))? substr($studentPlacement["Initial Mastery %"],0,-1):0 ;
					$moduleProgression -> current_mastery = is_numeric(substr($studentPlacement["Current Mastery %"],0,-1))?substr($studentPlacement["Current Mastery %"],0,-1):0;
					$moduleProgression -> current_number_of_topics_learned = is_numeric($studentPlacement["Total Number of Topics Learned"])?$studentPlacement["Total Number of Topics Learned"]:0;
					$moduleProgression -> current_number_of_topics_learned_per_hour= is_numeric($studentPlacement["Total Number of Topics Learned per Hour"]) ? $studentPlacement["Total Number of Topics Learned per Hour"]:0;
					$moduleProgression -> current_total_hours_in_aleks_prep = is_numeric( $studentPlacement["Total Hours in ALEKS Prep"])?  $studentPlacement["Total Hours in ALEKS Prep"]:0;
					$moduleProgression -> save(); 

				}
            }
        }
    }

}
