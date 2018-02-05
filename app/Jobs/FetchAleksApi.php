<?php

namespace App\Jobs;
use App\Student;
use App\LoginLog;
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
        //
        $aleksUser = env('ALEKS_USER');
        $aleksPass = env('ALEKS_PASSWORD');
        $aleksClassCode = "VMLUU-AQMAC";
        $aleksUrl = "https://api.aleks.com/urlrpc?method=getPlacementReport&username={$aleksUser}&password={$aleksPass}&class_code={$aleksClassCode}&type=all&show_prep=true";
        $options = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
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
                $student -> class_code = $aleksClassCode;
                $student->save();
            }
            $loginLog = new LoginLog();
            $loginLog -> student_id = $student -> id;
            $loginLog -> date = date('Y-m-d', strtotime($studentPlacement["Last login"]));
            $loginLog -> save();

        }

    }
}
