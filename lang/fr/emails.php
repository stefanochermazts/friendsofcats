<?php

return [
    // Email de vérification
    'verification' => [
        'subject' => 'Vérifiez votre adresse email - :app_name',
        'welcome' => '🎉 Bienvenue sur :app_name !',
        'greeting' => 'Bonjour :name,',
        'message' => 'Merci de vous être inscrit ! Pour compléter votre inscription et accéder à toutes les fonctionnalités, vous devez vérifier votre adresse email en cliquant sur le bouton ci-dessous.',
        'verify_button' => '✅ Vérifier l\'Email',
        'manual_link_text' => 'Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :',
        'security_note_title' => '🔒 Sécurité :',
        'security_note_text' => 'Ce lien n\'est valide que 60 minutes pour des raisons de sécurité. Si vous ne pouvez pas vérifier votre email à temps, vous pourrez demander un nouveau lien de vérification.',
        'footer_text' => 'Cet email a été envoyé par :app_name. Si vous n\'avez pas demandé cette inscription, vous pouvez ignorer cet email.',
        'date_time' => 'Date et heure : :datetime',
    ],

    // Email de notification d'inscription admin
    'registration_notification' => [
        'subject' => 'Nouvel utilisateur inscrit - :app_name',
        'title' => '🎉 Nouvel utilisateur inscrit !',
        'subtitle' => 'Un nouvel utilisateur vient de s\'inscrire sur :app_name',
        'user_details' => 'Détails de l\'utilisateur :',
        'name' => 'Nom :',
        'email' => 'Email :',
        'registration_date' => 'Date d\'inscription :',
        'role' => 'Rôle :',
        'success_message' => 'L\'utilisateur a été inscrit avec succès et peut maintenant accéder à la plateforme.',
        'footer_text' => 'Ceci est une notification automatique envoyée par :app_name.',
        'date_time' => 'Date et heure : :datetime',
    ],
]; 