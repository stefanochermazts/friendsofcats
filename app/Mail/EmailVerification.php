<?php

declare(strict_types=1);

namespace App\Mail;

use App\Helpers\EmailTranslations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $verificationUrl,
        public string $userName
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: EmailTranslations::get('emails.verification.subject', ['app_name' => config('app.name')]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $appUrl = rtrim(config('app.url'), '/');

        return new Content(
            view: 'emails.email-verification',
            with: [
                'verificationUrl' => $this->verificationUrl,
                'userName' => $this->userName,
                'appName' => config('app.name'),
                'logoUrl' => $appUrl . '/images/cat-logo.svg',
                'locale' => app()->getLocale(),
                'translations' => EmailTranslations::getTranslations(app()->getLocale()),
                'title' => 'Verifica il tuo indirizzo email',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 