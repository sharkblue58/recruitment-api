<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(public $user) {}

    public function build()
    {
        return $this->subject('Welcome to Our App!')
            ->view('emails.welcome')
            ->with(['user' => $this->user]);
    }
}
