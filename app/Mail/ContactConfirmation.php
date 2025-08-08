<?php

declare(strict_types=1);

namespace App\Mail;

use App\Helpers\EmailTranslations;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Contact $contact
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: EmailTranslations::get('emails.contact_confirmation.subject', ['app_name' => config('app.name')]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $appUrl = rtrim(config('app.url'), '/');

        return new Content(
            view: 'emails.contact-confirmation',
            with: [
                'contact' => $this->contact,
                'appName' => config('app.name'),
                'logoUrlLight' => $appUrl . '/images/cat-logo.svg',
                'logoUrlDark' => $appUrl . '/images/cat-logo-dark.svg',
                'locale' => app()->getLocale(),
                'translations' => EmailTranslations::getTranslations(app()->getLocale()),
                'title' => 'Conferma ricezione messaggio',
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