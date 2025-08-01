@extends('emails.layouts.minimal')

@section('content')
    <h1 style="margin: 0 0 20px 0; font-size: 24px; color: #000000;">
        {{ $translations['verification']['welcome'] }}
    </h1>
    
    <div style="margin-bottom: 20px;">
        <p style="font-size: 16px; margin: 0 0 15px 0;">
            {{ str_replace(':name', $userName, $translations['verification']['greeting']) }}
        </p>
        
        <p style="font-size: 14px; line-height: 1.6; margin: 0;">
            {{ $translations['verification']['message'] }}
        </p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $verificationUrl }}" class="button">
            {{ $translations['verification']['verify_button'] }}
        </a>
    </div>
    
    <div class="info-box">
        <p style="margin: 0; font-size: 14px;">
            {{ $translations['verification']['manual_link_text'] }}
            <br>
            <a href="{{ $verificationUrl }}" style="color: #000000; text-decoration: underline;">{{ $verificationUrl }}</a>
        </p>
    </div>
    
    <div class="security-note">
        <p style="margin: 0; font-size: 14px;">
            <strong>{{ $translations['verification']['security_note_title'] }}</strong> 
            {{ $translations['verification']['security_note_text'] }}
        </p>
    </div>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e5e5;">
        <p style="margin: 0; font-size: 12px; color: #666;">
            {{ $translations['verification']['footer_text'] }}
        </p>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">
            {{ str_replace(':datetime', now()->format('d/m/Y H:i:s'), $translations['verification']['date_time']) }}
        </p>
    </div>
@endsection 