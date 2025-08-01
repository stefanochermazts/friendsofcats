@extends('emails.layouts.minimal')

@section('content')
    <h1 style="margin: 0 0 20px 0; font-size: 24px; color: #000000;">
        {{ $translations['contact_confirmation']['title'] }}
    </h1>
    
    <div style="margin-bottom: 20px;">
        <p style="font-size: 16px; margin: 0 0 15px 0;">
            {{ str_replace(':name', $contact->name, $translations['contact_confirmation']['greeting']) }}
        </p>
        
        <p style="font-size: 14px; line-height: 1.6; margin: 0;">
            {{ $translations['contact_confirmation']['message'] }}
        </p>
    </div>
    
    <div class="info-box">
        <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #000000;">
            {{ $translations['contact_confirmation']['details_title'] }}
        </h3>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_confirmation']['subject_label'] }}:</strong> {{ $contact->subject }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_confirmation']['message_label'] }}:</strong>
            <p style="margin: 5px 0 0 0; font-size: 14px; line-height: 1.5;">
                {{ $contact->message }}
            </p>
        </div>
        
        <div>
            <strong>{{ $translations['contact_confirmation']['date'] }}:</strong> {{ $contact->created_at->format('d/m/Y H:i:s') }}
        </div>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 4px;">
        <p style="margin: 0; font-size: 14px; line-height: 1.6;">
            {{ $translations['contact_confirmation']['response_time'] }}
        </p>
    </div>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e5e5;">
        <p style="margin: 0; font-size: 12px; color: #666;">
            {{ $translations['contact_confirmation']['footer_text'] }}
        </p>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">
            {{ str_replace(':datetime', now()->format('d/m/Y H:i:s'), $translations['contact_confirmation']['date_time']) }}
        </p>
    </div>
@endsection 