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

class ContactNotification extends Mailable
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
        // Personalizza l'oggetto se è una richiesta di adozione
        $subject = $this->isAdoptionRequest() 
            ? EmailTranslations::get('emails.contact_notification.adoption_subject', [
                'app_name' => config('app.name'),
                'cat_name' => $this->extractCatNameFromSubject()
            ])
            : EmailTranslations::get('emails.contact_notification.subject', ['app_name' => config('app.name')]);
            
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $appUrl = rtrim(config('app.url'), '/');

        return new Content(
            view: 'emails.contact-notification',
            with: [
                'contact' => $this->contact,
                'appName' => config('app.name'),
                'logoUrlLight' => $appUrl . '/images/cat-logo.svg',
                'logoUrlDark' => $appUrl . '/images/cat-logo.svg',
                'locale' => app()->getLocale(),
                'translations' => EmailTranslations::getTranslations(app()->getLocale()),
                'title' => $this->isAdoptionRequest() ? 'Richiesta di adozione' : 'Nuovo messaggio di contatto',
                'isAdoptionRequest' => $this->isAdoptionRequest(),
                'catName' => $this->extractCatNameFromSubject(),
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

    /**
     * Verifica se è una richiesta di adozione
     */
    private function isAdoptionRequest(): bool
    {
        return str_contains(strtolower($this->contact->subject), 'richiesta adozione');
    }

    /**
     * Estrae il nome del gatto dall'oggetto della richiesta
     */
    private function extractCatNameFromSubject(): ?string
    {
        if (preg_match('/richiesta adozione per (.+?)$/i', $this->contact->subject, $matches)) {
            return trim($matches[1]);
        }
        
        return null;
    }
}
