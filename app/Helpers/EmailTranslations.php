<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class EmailTranslations
{
    /**
     * Get translated text for emails with proper locale setting.
     */
    public static function get(string $key, array $replace = [], string $locale = null): string
    {
        // Imposta la lingua se specificata
        if ($locale) {
            App::setLocale($locale);
        }
        
        // Forza il caricamento delle traduzioni
        $translation = __($key, $replace);
        
        // Se la traduzione è uguale alla chiave, prova a caricare manualmente
        if ($translation === $key) {
            $locale = App::getLocale();
            $path = lang_path("{$locale}/emails.php");
            
            if (file_exists($path)) {
                $translations = require $path;
                $keys = explode('.', $key);
                
                $value = $translations;
                foreach ($keys as $k) {
                    if (isset($value[$k])) {
                        $value = $value[$k];
                    } else {
                        return $key; // Fallback alla chiave
                    }
                }
                
                // Applica le sostituzioni
                foreach ($replace as $placeholder => $replacement) {
                    $value = str_replace(":{$placeholder}", $replacement, $value);
                }
                
                return $value;
            }
        }
        
        return $translation;
    }

    /**
     * Get all translations for a specific locale.
     */
    public static function getTranslations(string $locale): array
    {
        $originalLocale = App::getLocale();
        App::setLocale($locale);
        
        // Carica manualmente le traduzioni
        $emailsPath = lang_path("{$locale}/emails.php");
        $emailsTranslations = file_exists($emailsPath) ? require $emailsPath : [];
        
        $translations = [
            'verification' => [
                'subject' => self::get('emails.verification.subject', ['app_name' => config('app.name')], $locale),
                'welcome' => self::get('emails.verification.welcome', ['app_name' => config('app.name')], $locale),
                'greeting' => self::get('emails.verification.greeting', [], $locale),
                'message' => self::get('emails.verification.message', [], $locale),
                'verify_button' => self::get('emails.verification.verify_button', [], $locale),
                'manual_link_text' => self::get('emails.verification.manual_link_text', [], $locale),
                'security_note_title' => self::get('emails.verification.security_note_title', [], $locale),
                'security_note_text' => self::get('emails.verification.security_note_text', [], $locale),
                'footer_text' => self::get('emails.verification.footer_text', ['app_name' => config('app.name')], $locale),
                'date_time' => self::get('emails.verification.date_time', [], $locale),
            ],
            'registration_notification' => [
                'subject' => self::get('emails.registration_notification.subject', ['app_name' => config('app.name')], $locale),
                'title' => self::get('emails.registration_notification.title', [], $locale),
                'subtitle' => self::get('emails.registration_notification.subtitle', ['app_name' => config('app.name')], $locale),
                'user_details' => self::get('emails.registration_notification.user_details', [], $locale),
                'name' => self::get('emails.registration_notification.name', [], $locale),
                'email' => self::get('emails.registration_notification.email', [], $locale),
                'registration_date' => self::get('emails.registration_notification.registration_date', [], $locale),
                'role' => self::get('emails.registration_notification.role', [], $locale),
                'success_message' => self::get('emails.registration_notification.success_message', [], $locale),
                'footer_text' => self::get('emails.registration_notification.footer_text', ['app_name' => config('app.name')], $locale),
                'date_time' => self::get('emails.registration_notification.date_time', [], $locale),
            ],
            'contact_confirmation' => [
                'subject' => self::get('emails.contact_confirmation.subject', ['app_name' => config('app.name')], $locale),
                'title' => self::get('emails.contact_confirmation.title', [], $locale),
                'greeting' => self::get('emails.contact_confirmation.greeting', [], $locale),
                'message' => self::get('emails.contact_confirmation.message', [], $locale),
                'details_title' => self::get('emails.contact_confirmation.details_title', [], $locale),
                'subject_label' => self::get('emails.contact_confirmation.subject_label', [], $locale),
                'message_label' => self::get('emails.contact_confirmation.message_label', [], $locale),
                'date' => self::get('emails.contact_confirmation.date', [], $locale),
                'response_time' => self::get('emails.contact_confirmation.response_time', [], $locale),
                'footer_text' => self::get('emails.contact_confirmation.footer_text', [], $locale),
                'date_time' => self::get('emails.contact_confirmation.date_time', [], $locale),
            ],
            'contact_notification' => [
                'subject' => self::get('emails.contact_notification.subject', ['app_name' => config('app.name')], $locale),
                'title' => self::get('emails.contact_notification.title', [], $locale),
                'subtitle' => self::get('emails.contact_notification.subtitle', [], $locale),
                'message' => self::get('emails.contact_notification.message', [], $locale),
                'contact_details' => self::get('emails.contact_notification.contact_details', [], $locale),
                'name' => self::get('emails.contact_notification.name', [], $locale),
                'email' => self::get('emails.contact_notification.email', [], $locale),
                'subject_label' => self::get('emails.contact_notification.subject_label', [], $locale),
                'message_label' => self::get('emails.contact_notification.message_label', [], $locale),
                'date' => self::get('emails.contact_notification.date', [], $locale),
                'action_required' => self::get('emails.contact_notification.action_required', [], $locale),
                'action_message' => self::get('emails.contact_notification.action_message', [], $locale),
                'footer_text' => self::get('emails.contact_notification.footer_text', [], $locale),
                'date_time' => self::get('emails.contact_notification.date_time', [], $locale),
            ],
        ];
        
        // Ripristina la lingua originale
        App::setLocale($originalLocale);
        
        return $translations;
    }
} 