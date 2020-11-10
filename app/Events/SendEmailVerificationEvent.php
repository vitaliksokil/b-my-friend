<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SendEmailVerificationEvent
{
    use Dispatchable, SerializesModels;
    public $data;
    public $to_name;
    public $to_email;

    /**
     * Create a new event instance.
     *
     * @param array $data
     * @param string $to_name
     * @param string $to_email
     */
    public function __construct(array $data,string $to_name,string $to_email)
    {
        $this->data = $data;
        $this->to_name = $to_name;
        $this->to_email = $to_email;
    }

}
