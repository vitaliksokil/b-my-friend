<?php


namespace App\Services\EmailService;


use Illuminate\Support\Facades\Mail;

class EmailService implements EmailServiceInterface
{

    public function send(string $emailTemplate, string $subject, array $data, string $to_email)
    {
        Mail::send($emailTemplate, $data, function ($message) use ($to_email,$subject) {
            $message->to($to_email)
                ->subject($subject);
            $message->from(config('mail.from.name'), 'b-my-friend');
        });
    }
}
