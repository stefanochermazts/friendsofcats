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
    
    // Contact confirmation email
    'contact_confirmation' => [
        'subject' => 'Message received confirmation - :app_name',
        'title' => '✅ Message received!',
        'greeting' => 'Hello :name,',
        'message' => 'Thank you for contacting us! We have received your message and will reply as soon as possible.',
        'details_title' => 'Message details:',
        'subject' => 'Subject',
        'message' => 'Message',
        'date' => 'Sent date',
        'response_time' => 'We will reply within 24-48 working hours.',
        'footer_text' => 'This email was sent automatically by the contact system.',
        'date_time' => 'Date and time: :datetime',
    ],
    
    // Contact notification email admin
    'contact_notification' => [
        'subject' => 'New contact message - :app_name',
        'adoption_subject' => 'Adoption request for :cat_name - :app_name',
        'title' => '📧 New contact message',
        'adoption_title' => '🐱 Adoption request',
        'adoption_subtitle' => 'Someone is interested in adopting one of your cats!',
        'adoption_message' => 'Here are the details of the adoption request:',
        'subtitle' => 'A new message has been received from the contact form.',
        'message' => 'Below are the details of the received message:',
        'contact_details' => 'Contact details:',
        'name' => 'Name',
        'email' => 'Email',
        'subject' => 'Subject',
        'message' => 'Message',
        'date' => 'Sent date',
        'action_required' => 'Action required:',
        'adoption_action_message' => 'Please reply to this adoption request as soon as possible.',
        'action_message' => 'Reply to the message using the email provided by the contact.',
        'footer_text' => 'This email was sent automatically by the contact system.',
        'date_time' => 'Date and time: :datetime',
    ],
]; 