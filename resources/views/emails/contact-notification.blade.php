@extends('emails.layouts.minimal')

@section('content')
    <h1 style="margin: 0 0 20px 0; font-size: 24px; color: #000000;">
        {{ $translations['contact_notification']['title'] }}
    </h1>
    
    <div style="margin-bottom: 20px;">
        <p style="font-size: 16px; margin: 0 0 15px 0;">
            {{ $translations['contact_notification']['subtitle'] }}
        </p>
        
        <p style="font-size: 14px; line-height: 1.6; margin: 0;">
            {{ $translations['contact_notification']['message'] }}
        </p>
    </div>
    
    <div class="user-details">
        <h3 style="margin: 0 0 15px 0; font-size: 18px; color: #000000;">
            {{ $translations['contact_notification']['contact_details'] }}
        </h3>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['name'] }}:</strong> {{ $contact->name }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['email'] }}:</strong> {{ $contact->email }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['subject_label'] }}:</strong> {{ $contact->subject }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['message_label'] }}:</strong>
            <p style="margin: 5px 0 0 0; font-size: 14px; line-height: 1.5;">
                {{ $contact->message }}
            </p>
        </div>
        
        <div>
            <strong>{{ $translations['contact_notification']['date'] }}:</strong> {{ $contact->created_at->format('d/m/Y H:i:s') }}
        </div>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background-color: #fff5f5; border: 1px solid #fed7d7; border-radius: 4px;">
        <p style="margin: 0; font-size: 14px; line-height: 1.6;">
            <strong>{{ $translations['contact_notification']['action_required'] }}</strong>
            {{ $translations['contact_notification']['action_message'] }}
        </p>
    </div>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e5e5;">
        <p style="margin: 0; font-size: 12px; color: #666;">
            {{ $translations['contact_notification']['footer_text'] }}
        </p>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">
            {{ str_replace(':datetime', now()->format('d/m/Y H:i:s'), $translations['contact_notification']['date_time']) }}
        </p>
    </div>
@endsection 