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
                'logoUrlDark' => $appUrl . '/images/cat-logo-dark.svg',
                'locale' => app()->getLocale(),
                'translations' => EmailTranslations::getTranslations(app()->getLocale()),
                'title' => $this->isAdoptionRequest() 
                    ? EmailTranslations::get('emails.contact_notification.adoption_title') 
                    : EmailTranslations::get('emails.contact_notification.title'),
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
        $subject = mb_strtolower($this->contact->subject ?? '');
        $patterns = [
            'richiesta adozione', // it
            'adoption request', // en
            "demande d'adoption", // fr
            'adoptionsanfrage', // de
            'solicitud de adopción', // es
            'zahteva za posvojitev', // sl
        ];
        foreach ($patterns as $p) {
            if (str_contains($subject, $p)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Estrae il nome del gatto dall'oggetto della richiesta
     */
    private function extractCatNameFromSubject(): ?string
    {
        $subject = $this->contact->subject ?? '';
        $regexes = [
            '/richiesta adozione per (.+)$/i', // it
            '/adoption request for (.+)$/i', // en
            "/demande d['’]adoption pour (.+)$/i", // fr
            '/adoptionsanfrage f[üu]r (.+)$/i', // de (ü or u as fallback)
            '/solicitud de adopci[oó]n para (.+)$/i', // es
            '/zahteva za posvojitev za (.+)$/i', // sl
        ];
        foreach ($regexes as $re) {
            if (preg_match($re, $subject, $m)) {
                return trim($m[1]);
            }
        }
        return null;
    }
}
