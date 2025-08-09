<?php

return [
    // E-Mail-Verifizierung
    'verification' => [
        'subject' => 'Bestätigen Sie Ihre E-Mail-Adresse - :app_name',
        'welcome' => '🎉 Willkommen bei :app_name!',
        'greeting' => 'Hallo :name,',
        'message' => 'Vielen Dank für Ihre Registrierung! Um Ihre Registrierung abzuschließen und Zugang zu allen Funktionen zu erhalten, müssen Sie Ihre E-Mail-Adresse bestätigen, indem Sie auf die Schaltfläche unten klicken.',
        'verify_button' => '✅ E-Mail bestätigen',
        'manual_link_text' => 'Wenn die Schaltfläche nicht funktioniert, kopieren Sie diesen Link und fügen Sie ihn in Ihren Browser ein:',
        'security_note_title' => '🔒 Sicherheit:',
        'security_note_text' => 'Dieser Link ist aus Sicherheitsgründen nur 60 Minuten gültig. Wenn Sie Ihre E-Mail nicht rechtzeitig bestätigen können, können Sie einen neuen Bestätigungslink anfordern.',
        'footer_text' => 'Diese E-Mail wurde von :app_name gesendet. Wenn Sie diese Registrierung nicht angefordert haben, können Sie diese E-Mail ignorieren.',
        'date_time' => 'Datum und Uhrzeit: :datetime',
    ],

    // Registrierungsbenachrichtigung Admin-E-Mail
    'registration_notification' => [
        'subject' => 'Neuer Benutzer registriert - :app_name',
        'title' => '🎉 Neuer Benutzer registriert!',
        'subtitle' => 'Ein neuer Benutzer hat sich gerade bei :app_name registriert',
        'user_details' => 'Benutzerdetails:',
        'name' => 'Name:',
        'email' => 'E-Mail:',
        'registration_date' => 'Registrierungsdatum:',
        'role' => 'Rolle:',
        'success_message' => 'Der Benutzer wurde erfolgreich registriert und kann jetzt auf die Plattform zugreifen.',
        'footer_text' => 'Dies ist eine automatische Benachrichtigung von :app_name.',
        'date_time' => 'Datum und Uhrzeit: :datetime',
    ],

    // Kontaktbestätigung
    'contact_confirmation' => [
        'subject' => 'Bestätigung des Nachrichteneingangs - :app_name',
        'title' => '✅ Nachricht erhalten!',
        'greeting' => 'Hallo :name,',
        'message' => 'Vielen Dank für Ihre Nachricht! Wir haben sie erhalten und melden uns so schnell wie möglich.',
        'details_title' => 'Nachrichtendetails:',
        'subject_label' => 'Betreff',
        'message_label' => 'Nachricht',
        'date' => 'Sendedatum',
        'response_time' => 'Wir antworten innerhalb von 24-48 Arbeitsstunden.',
        'footer_text' => 'Diese E-Mail wurde automatisch vom Kontakt-System gesendet.',
        'date_time' => 'Datum und Uhrzeit: :datetime',
    ],

    // Kontaktbenachrichtigung
    'contact_notification' => [
        'subject' => 'Neue Kontaktanfrage - :app_name',
        'adoption_subject' => 'Adoptionsanfrage für :cat_name - :app_name',
        'title' => '📧 Neue Kontaktanfrage',
        'adoption_title' => '🐱 Adoptionsanfrage',
        'subtitle' => 'Über das Kontaktformular ist eine neue Nachricht eingegangen.',
        'adoption_subtitle' => 'Jemand interessiert sich für die Adoption einer Ihrer Katzen!',
        'message' => 'Nachfolgend die Details der empfangenen Nachricht:',
        'adoption_message' => 'Nachfolgend die Details der Adoptionsanfrage:',
        'contact_details' => 'Kontaktdaten:',
        'name' => 'Name',
        'email' => 'E-Mail',
        'subject_label' => 'Betreff',
        'message_label' => 'Nachricht',
        'date' => 'Sendedatum',
        'action_required' => 'Erforderliche Aktion:',
        'adoption_action_message' => 'Bitte antworten Sie auf diese Adoptionsanfrage so schnell wie möglich.',
        'action_message' => 'Antworten Sie auf die Nachricht über die angegebene E-Mail-Adresse.',
        'footer_text' => 'Diese E-Mail wurde automatisch vom Kontakt-System gesendet.',
        'date_time' => 'Datum und Uhrzeit: :datetime',
    ],
]; 