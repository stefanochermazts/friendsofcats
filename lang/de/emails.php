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
]; 