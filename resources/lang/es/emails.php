<?php

return [
    // Verificación de email
    'verification' => [
        'subject' => 'Verifica tu dirección de email - :app_name',
        'welcome' => '🎉 ¡Bienvenido a :app_name!',
        'greeting' => 'Hola :name,',
        'message' => '¡Gracias por registrarte! Para completar tu registro y acceder a todas las funcionalidades, debes verificar tu dirección de email haciendo clic en el botón de abajo.',
        'verify_button' => '✅ Verificar Email',
        'manual_link_text' => 'Si el botón no funciona, copia y pega este enlace en tu navegador:',
        'security_note_title' => '🔒 Seguridad:',
        'security_note_text' => 'Este enlace es válido solo por 60 minutos por razones de seguridad. Si no puedes verificar tu email a tiempo, podrás solicitar un nuevo enlace de verificación.',
        'footer_text' => 'Este email fue enviado por :app_name. Si no solicitaste este registro, puedes ignorar este email.',
        'date_time' => 'Fecha y hora: :datetime',
    ],

    // Email de notificación de registro admin
    'registration_notification' => [
        'subject' => 'Nuevo usuario registrado - :app_name',
        'title' => '🎉 ¡Nuevo usuario registrado!',
        'subtitle' => 'Un nuevo usuario se acaba de registrar en :app_name',
        'user_details' => 'Detalles del usuario:',
        'name' => 'Nombre:',
        'email' => 'Email:',
        'registration_date' => 'Fecha de registro:',
        'role' => 'Rol:',
        'success_message' => 'El usuario ha sido registrado exitosamente y ahora puede acceder a la plataforma.',
        'footer_text' => 'Esta es una notificación automática enviada por :app_name.',
        'date_time' => 'Fecha y hora: :datetime',
    ],
]; 