<?php

return [
    // Email di verifica
    'verification' => [
        'subject' => 'Verifica il tuo indirizzo email - :app_name',
        'welcome' => '🎉 Benvenuto su :app_name!',
        'greeting' => 'Ciao :name,',
        'message' => 'Grazie per esserti registrato! Per completare la registrazione e accedere a tutte le funzionalità, devi verificare il tuo indirizzo email cliccando sul pulsante qui sotto.',
        'verify_button' => '✅ Verifica Email',
        'manual_link_text' => 'Se il pulsante non funziona, copia e incolla questo link nel tuo browser:',
        'security_note_title' => '🔒 Sicurezza:',
        'security_note_text' => 'Questo link è valido solo per 60 minuti per motivi di sicurezza. Se non riesci a verificare l\'email in tempo, potrai richiedere un nuovo link di verifica.',
        'footer_text' => 'Questa email è stata inviata da :app_name. Se non hai richiesto questa registrazione, puoi ignorare questa email.',
        'date_time' => 'Data e ora: :datetime',
    ],

    // Email di notifica registrazione admin
    'registration_notification' => [
        'subject' => 'Nuovo utente registrato - :app_name',
        'title' => '🎉 Nuovo utente registrato!',
        'subtitle' => 'Un nuovo utente si è appena registrato su :app_name',
        'user_details' => 'Dettagli dell\'utente:',
        'name' => 'Nome:',
        'email' => 'Email:',
        'registration_date' => 'Data di registrazione:',
        'role' => 'Ruolo:',
        'success_message' => 'L\'utente è stato registrato con successo e può ora accedere alla piattaforma.',
        'footer_text' => 'Questa è una notifica automatica inviata da :app_name.',
        'date_time' => 'Data e ora: :datetime',
    ],
    
    // Email di conferma contatto
    'contact_confirmation' => [
        'subject' => 'Conferma ricezione messaggio - :app_name',
        'title' => '✅ Messaggio ricevuto!',
        'greeting' => 'Ciao :name,',
        'message' => 'Grazie per averci contattato! Abbiamo ricevuto il tuo messaggio e ti risponderemo al più presto.',
        'details_title' => 'Dettagli del messaggio:',
        'subject_label' => 'Oggetto',
        'message_label' => 'Messaggio',
        'date' => 'Data di invio',
        'response_time' => 'Ti risponderemo entro 24-48 ore lavorative.',
        'footer_text' => 'Questa email è stata inviata automaticamente dal sistema di contatto.',
        'date_time' => 'Data e ora: :datetime',
    ],
    
    // Email di notifica contatto admin
    'contact_notification' => [
        'subject' => 'Nuovo messaggio di contatto - :app_name',
        'adoption_subject' => 'Richiesta adozione per :cat_name - :app_name',
        'title' => '📧 Nuovo messaggio di contatto',
        'adoption_title' => '🐱 Richiesta di adozione',
        'adoption_subtitle' => 'Qualcuno è interessato ad adottare uno dei tuoi gatti!',
        'adoption_message' => 'Ecco i dettagli della richiesta di adozione:',
        'message' => 'Di seguito i dettagli del messaggio ricevuto:',
        'contact_details' => 'Dettagli del contatto:',
        'name' => 'Nome',
        'email' => 'Email',
        'subject_label' => 'Oggetto',
        'message_label' => 'Messaggio',
        'date' => 'Data di invio',
        'action_required' => 'Azione richiesta:',
        'adoption_action_message' => 'Rispondi a questa richiesta di adozione il prima possibile.',
        'action_message' => 'Rispondi al messaggio utilizzando l\'email fornita dal contatto.',
        'footer_text' => 'Questa email è stata inviata automaticamente dal sistema di contatto.',
        'date_time' => 'Data e ora: :datetime',
    ],
]; 