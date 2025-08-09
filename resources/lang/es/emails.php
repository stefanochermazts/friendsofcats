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

    // Confirmación de contacto
    'contact_confirmation' => [
        'subject' => 'Confirmación de recepción del mensaje - :app_name',
        'title' => '✅ ¡Mensaje recibido!',
        'greeting' => 'Hola :name,',
        'message' => '¡Gracias por contactarnos! Hemos recibido tu mensaje y te responderemos lo antes posible.',
        'details_title' => 'Detalles del mensaje:',
        'subject_label' => 'Asunto',
        'message_label' => 'Mensaje',
        'date' => 'Fecha de envío',
        'response_time' => 'Responderemos dentro de 24-48 horas laborables.',
        'footer_text' => 'Este email fue enviado automáticamente por el sistema de contacto.',
        'date_time' => 'Fecha y hora: :datetime',
    ],

    // Notificación de contacto
    'contact_notification' => [
        'subject' => 'Nuevo mensaje de contacto - :app_name',
        'adoption_subject' => 'Solicitud de adopción para :cat_name - :app_name',
        'title' => '📧 Nuevo mensaje de contacto',
        'adoption_title' => '🐱 Solicitud de adopción',
        'subtitle' => 'Se ha recibido un nuevo mensaje desde el formulario de contacto.',
        'adoption_subtitle' => '¡Alguien está interesado en adoptar uno de tus gatos!',
        'message' => 'A continuación se muestran los detalles del mensaje recibido:',
        'adoption_message' => 'A continuación se muestran los detalles de la solicitud de adopción:',
        'contact_details' => 'Detalles de contacto:',
        'name' => 'Nombre',
        'email' => 'Email',
        'subject_label' => 'Asunto',
        'message_label' => 'Mensaje',
        'date' => 'Fecha de envío',
        'action_required' => 'Acción requerida:',
        'adoption_action_message' => 'Por favor, responde a esta solicitud de adopción lo antes posible.',
        'action_message' => 'Responde al mensaje usando el email proporcionado por el contacto.',
        'footer_text' => 'Este email fue enviado automáticamente por el sistema de contacto.',
        'date_time' => 'Fecha y hora: :datetime',
    ],
]; 