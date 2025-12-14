<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $verificationUrl;

    public function __construct(string $userName, string $verificationUrl)
    {
        $this->userName = $userName;
        $this->verificationUrl = $verificationUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifique Seu Email - Manager Box',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email', // Aponta para resources/views/emails/verify-email.blade.php
        );
    }
}
