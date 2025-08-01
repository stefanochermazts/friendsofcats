<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactConfirmation;
use App\Mail\ContactNotification;
use App\Models\Contact;
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
            
            // Step 3: Invia email di notifica all'amministratore
            try {
                $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL'));
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new ContactNotification($contact));
                    Log::info('Notification email sent to admin', ['admin_email' => $adminEmail]);
                }
            } catch (\Exception $emailError) {
                Log::error('Failed to send admin notification email', ['error' => $emailError->getMessage()]);
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
}
