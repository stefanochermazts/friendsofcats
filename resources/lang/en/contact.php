<?php

return [
    'subject_professional' => 'Inquiry to :name',
    'message_professional_prefill' => "Hello :professional,\n\nI saw your profile on :platform and would like to know more about your services.\n\nCould you please share availability, pricing and how to book?\n\nThank you,\n\nKind regards",
    'subject_adoption' => 'Adoption request for :cat',
    'message_adoption_prefill' => "Hello :association,\n\nI am interested in adopting :cat, which I saw on your profile on :platform.\n\nCould you please provide more information about the adoption process and next steps?\n\nThank you!\n\nKind regards",
    'title' => 'Contact Us',
    'subtitle' => 'We are here to help. Contact us for any questions or requests.',
    'contact_info' => 'Contact Information',
    'send_message' => 'Send a Message',
    'follow_us' => 'Follow Us on Social Media',
    
    // Form fields
    'name' => 'Name',
    'email' => 'Email',
    'subject' => 'Subject',
    'message' => 'Message',
    'send' => 'Send Message',
    
    // Contact information
    'phone' => 'Phone',
    'hours' => 'Hours',
    'hours_text' => 'Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 12:00 PM<br>Sunday: Closed',
    'address' => 'Address',
    'address_text' => 'Via dei Gatti, 123<br>00100 Rome, Italy',
    
    // Messages
    'message_sent' => 'Your message has been sent successfully! We will reply as soon as possible.',
    'message_error' => 'An error occurred while sending the message. Please try again later.',
    
    // Validation
    'validation' => [
        'name_required' => 'The name field is required.',
        'name_max' => 'The name may not be greater than 255 characters.',
        'email_required' => 'The email field is required.',
        'email_invalid' => 'The email must be a valid email address.',
        'email_max' => 'The email may not be greater than 255 characters.',
        'subject_required' => 'The subject field is required.',
        'subject_max' => 'The subject may not be greater than 255 characters.',
        'message_required' => 'The message field is required.',
        'message_max' => 'The message may not be greater than 1000 characters.',
    ],
]; 