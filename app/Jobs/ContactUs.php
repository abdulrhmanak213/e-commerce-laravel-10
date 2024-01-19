<?php

namespace App\Jobs;

use App\Mail\ContactUsMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ContactUs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data ;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data ;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to(env('ADMIN_MAIL'),'contact-us')->send(new ContactUsMail($this->data));
    }
}
