<?php

namespace App\Mail;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsSkipVerano extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $student;
    public $tries = 1;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mg@utpaleks.com')
            ->subject('Con ALEKS PPL puedes tener tu verano libre | UTP-Aleks PPL')
            ->view('mails.news_on_course')->with(["student" => $this->student]);
    }
}
