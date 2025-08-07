<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactConfirmation;
use App\Mail\ContactNotification;
use App\Models\Contact;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index(): View
    {
        return view('contact');
    }

    /**
     * Handle contact form submission.
     */
    public function store(ContactRequest $request)
    {
        try {
            // Step 1: Crea il record del contatto
            $contactData = $request->validated();
            $contactData['status'] = 'new'; // Imposta lo status di default
            $contact = Contact::create($contactData);
            
            Log::info('Contact created successfully', ['id' => $contact->id, 'email' => $contact->email]);
            
            // Step 2: Invia email di conferma al mittente
            try {
                Mail::to($contact->email)->send(new ContactConfirmation($contact));
                Log::info('Confirmation email sent to user', ['email' => $contact->email]);
            } catch (\Exception $emailError) {
                Log::error('Failed to send confirmation email', ['error' => $emailError->getMessage()]);
                // Continua anche se l'email fallisce
            }
            
            // Step 3: Invia email di notifica (all'associazione o all'admin)
            try {
                $recipientEmail = $this->getRecipientEmail($request);
                $recipientType = $this->getRecipientType($request);
                
                // Logging dettagliato per debug
                Log::info('Contact form submission details', [
                    'has_gatto' => $request->has('gatto'),
                    'has_associazione' => $request->has('associazione'),
                    'gatto_value' => $request->get('gatto'),
                    'associazione_value' => $request->get('associazione'),
                    'recipient_email' => $recipientEmail,
                    'recipient_type' => $recipientType,
                    'contact_subject' => $contact->subject
                ]);
                
                if ($recipientEmail) {
                    Mail::to($recipientEmail)->send(new ContactNotification($contact));
                    Log::info("Notification email sent to {$recipientType}", [
                        'recipient_email' => $recipientEmail,
                        'type' => $recipientType
                    ]);
                }
            } catch (\Exception $emailError) {
                Log::error('Failed to send notification email', ['error' => $emailError->getMessage()]);
                // Continua anche se l'email fallisce
            }
            
            return back()->with('success', __('contact.message_sent'));
        } catch (\Exception $e) {
            // Log l'errore per debugging
            Log::error('Contact form error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Temporaneamente mostra l'errore specifico per debugging
            $errorMessage = app()->environment('local') 
                ? 'Errore: ' . $e->getMessage() . ' (Linea: ' . $e->getLine() . ')'
                : __('contact.message_error');
            
            return back()
                ->withInput()
                ->withErrors(['error' => $errorMessage]);
        }
    }

    /**
     * Determina l'email del destinatario in base al contesto della richiesta
     */
    private function getRecipientEmail(ContactRequest $request): ?string
    {
        // Controlla se è una richiesta di adozione per un gatto specifico
        if ($request->has('gatto') && $request->has('associazione')) {
            $catName = $request->get('gatto');
            $associationName = $request->get('associazione');
            
            Log::info('Looking for cat and association', [
                'cat_name' => $catName,
                'association_name' => $associationName
            ]);
            
            // Trova il gatto e la sua associazione
            $cat = Cat::where('nome', $catName)
                     ->where('disponibile_adozione', true)
                     ->with('user')
                     ->first();
            
            if ($cat && $cat->user) {
                // Verifica che il nome dell'associazione corrisponda
                $userDisplayName = $cat->user->ragione_sociale ?? $cat->user->name;
                
                Log::info('Cat found, checking association match', [
                    'cat_id' => $cat->id,
                    'user_display_name' => $userDisplayName,
                    'requested_association' => $associationName,
                    'match' => $userDisplayName === $associationName,
                    'user_email' => $cat->user->email
                ]);
                
                if ($userDisplayName === $associationName) {
                    return $cat->user->email;
                }
            } else {
                Log::warning('Cat or user not found', [
                    'cat_name' => $catName,
                    'cat_found' => !!$cat,
                    'user_found' => $cat ? !!$cat->user : false
                ]);
            }
        }
        
        // Fallback all'email admin
        $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL'));
        Log::info('Using admin email fallback', ['admin_email' => $adminEmail]);
        return $adminEmail;
    }

    /**
     * Determina il tipo di destinatario per il logging
     */
    private function getRecipientType(ContactRequest $request): string
    {
        if ($request->has('gatto') && $request->has('associazione')) {
            return 'association';
        }
        
        return 'admin';
    }
}
