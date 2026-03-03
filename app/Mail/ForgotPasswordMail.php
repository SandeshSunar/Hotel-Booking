<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $resetLink;

    public function __construct($otp, $resetLink)
    {
        $this->otp = $otp;
        $this->resetLink = $resetLink;
    }

    public function build()
    {
        return $this->subject('Password Reset OTP')
                    ->view('email.forgot-password');
    }
}
