<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\User;
class SendEmailIfLoginLow implements ShouldQueue
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
        $users = User::all();
        $lowUsageUser = collect();
//        Mail::to('from@example.com')->send(new TestMail());
        foreach ($users as $user)
        {
            $daysSinceLogin = (time() - strtotime($user->lastLogin()))/(60*60*24);
            if($daysSinceLogin > 5)
            {
                Log::info('Sending email to student '. $user->name.'. Reason: '.$daysSinceLogin.' days without login in.');
            }
        }
 
    }
}
