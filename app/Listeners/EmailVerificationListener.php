<?php

namespace App\Listeners;


use App\Events\SendEmailVerificationEvent;
use Illuminate\Support\Facades\Mail;

class EmailVerificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SendEmailVerificationEvent $event
     * @return void
     */
    public function handle(SendEmailVerificationEvent $event)
    {
        Mail::send('emails.emailVerification', $event->data, function ($message) use ($event) {
            $message->to($event->to_email, $event->to_name)
                ->subject('b-my-friend Email Verification');
            $message->from(config('mail.from.name'), 'b-my-friend');
        });
    }
}
