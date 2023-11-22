<?php

namespace App\Jobs;

use App\Mail\SendEmailToQuestionnaireContact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToContacts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $emails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $data)
    {
        //
        $this->emails = $emails;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = $this->emails;
        Mail::to($emails)->send(new SendEmailToQuestionnaireContact($this->data));
    }
}
