<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetCode;
    public $email;

    public function __construct($resetCode, $email)
    {
        $this->resetCode = $resetCode;
        $this->email     = $email;
    }

    public function build()
    {
        return $this->subject('Reset Password Notification')
            ->view('emails.reset-password')
            ->with([
                'resetCode' => $this->resetCode,
                'email'     => $this->email,
            ]);
    }
}
