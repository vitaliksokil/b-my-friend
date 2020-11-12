<?php


namespace App\Services\EmailService;


interface EmailServiceInterface
{
    public function send(string $emailTemplate, string $subject, array $data, string $to_email);
}
