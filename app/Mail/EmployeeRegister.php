<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeRegister extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $token_hash)
    {
        $this->id = $id;
        $this->token_hash = $token_hash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = route('email_verify', ['id' => $this->id, 'token' => $this->token_hash]);
        return $this->subject('Weryfikacja maila')->view('emails.employeeRegister')->withUrl($url);
    }
}
