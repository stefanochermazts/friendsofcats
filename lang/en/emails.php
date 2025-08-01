<?php

return [
    // Email verification
    'verification' => [
        'subject' => 'Verify your email address - :app_name',
        'welcome' => '🎉 Welcome to :app_name!',
        'greeting' => 'Hello :name,',
        'message' => 'Thank you for registering! To complete your registration and access all features, you need to verify your email address by clicking the button below.',
        'verify_button' => '✅ Verify Email',
        'manual_link_text' => 'If the button doesn\'t work, copy and paste this link into your browser:',
        'security_note_title' => '🔒 Security:',
        'security_note_text' => 'This link is valid for only 60 minutes for security reasons. If you can\'t verify your email in time, you can request a new verification link.',
        'footer_text' => 'This email was sent by :app_name. If you didn\'t request this registration, you can ignore this email.',
        'date_time' => 'Date and time: :datetime',
    ],

    // Registration notification admin email
    'registration_notification' => [
        'subject' => 'New user registered - :app_name',
        'title' => '🎉 New user registered!',
        'subtitle' => 'A new user has just registered on :app_name',
        'user_details' => 'User details:',
        'name' => 'Name:',
        'email' => 'Email:',
        'registration_date' => 'Registration date:',
        'role' => 'Role:',
        'success_message' => 'The user has been successfully registered and can now access the platform.',
        'footer_text' => 'This is an automatic notification sent by :app_name.',
        'date_time' => 'Date and time: :datetime',
    ],
]; 