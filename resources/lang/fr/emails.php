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
        'subtitle' => 'Un nouvel utilisateur s\'est inscrit sur :app_name',
        'user_details' => 'Détails de l\'utilisateur :',
        'name' => 'Nom :',
        'email' => 'Email :',
        'registration_date' => 'Date d\'inscription :',
        'role' => 'Rôle :',
        'success_message' => 'L\'utilisateur a été inscrit avec succès et peut maintenant accéder à la plateforme.',
        'footer_text' => 'Ceci est une notification automatique envoyée par :app_name.',
        'date_time' => 'Date et heure : :datetime',
    ],

    // Confirmation de contact
    'contact_confirmation' => [
        'subject' => 'Confirmation de réception du message - :app_name',
        'title' => '✅ Message reçu !',
        'greeting' => 'Bonjour :name,',
        'message' => 'Merci de nous avoir contactés ! Nous avons bien reçu votre message et nous vous répondrons dès que possible.',
        'details_title' => 'Détails du message :',
        'subject_label' => 'Objet',
        'message_label' => 'Message',
        'date' => 'Date d\'envoi',
        'response_time' => 'Nous vous répondrons sous 24 à 48 heures ouvrées.',
        'footer_text' => 'Cet email a été envoyé automatiquement par le système de contact.',
        'date_time' => 'Date et heure : :datetime',
    ],

    // Notification de contact
    'contact_notification' => [
        'subject' => 'Nouveau message de contact - :app_name',
        'adoption_subject' => 'Demande d\'adoption pour :cat_name - :app_name',
        'title' => '📧 Nouveau message de contact',
        'adoption_title' => '🐱 Demande d\'adoption',
        'subtitle' => 'Un nouveau message a été reçu via le formulaire de contact.',
        'adoption_subtitle' => 'Quelqu\'un est intéressé par l\'adoption de l\'un de vos chats !',
        'message' => 'Voici les détails du message reçu :',
        'adoption_message' => 'Voici les détails de la demande d\'adoption :',
        'contact_details' => 'Détails du contact :',
        'name' => 'Nom',
        'email' => 'Email',
        'subject_label' => 'Objet',
        'message_label' => 'Message',
        'date' => 'Date d\'envoi',
        'action_required' => 'Action requise :',
        'adoption_action_message' => 'Veuillez répondre à cette demande d\'adoption dès que possible.',
        'action_message' => 'Répondez au message en utilisant l\'adresse email fournie par le contact.',
        'footer_text' => 'Cet email a été envoyé automatiquement par le système de contact.',
        'date_time' => 'Date et heure : :datetime',
    ],
]; 