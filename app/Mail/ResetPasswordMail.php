<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
        $this->url = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reset Password - Bank Sampah')
                    ->view('mail.password-reset')
                    ->with([
                        'url' => $this->url,
                        'user' => $this->user,
                    ]);
    }
}
