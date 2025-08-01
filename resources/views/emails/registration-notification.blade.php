@extends('emails.layouts.minimal')

@section('content')
    <h1 style="margin: 0 0 10px 0; font-size: 24px; color: #000000;">
        {{ $translations['registration_notification']['title'] }}
    </h1>
    
    <p style="margin: 0 0 30px 0; font-size: 16px; color: #666;">
        {{ $translations['registration_notification']['subtitle'] }}
    </p>
    
    <h2 style="margin: 0 0 20px 0; font-size: 18px; color: #000000;">
        {{ $translations['registration_notification']['user_details'] }}
    </h2>
    
    <div class="user-details">
        <p><strong>{{ $translations['registration_notification']['name'] }}</strong> {{ $user->name }}</p>
        <p><strong>{{ $translations['registration_notification']['email'] }}</strong> {{ $user->email }}</p>
        <p><strong>{{ $translations['registration_notification']['registration_date'] }}</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
        @if($user->role)
            <p><strong>{{ $translations['registration_notification']['role'] }}</strong> {{ ucfirst($user->role) }}</p>
        @endif
    </div>
    
    <p style="margin: 20px 0; font-size: 14px; line-height: 1.6;">
        {{ $translations['registration_notification']['success_message'] }}
    </p>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e5e5;">
        <p style="margin: 0; font-size: 12px; color: #666;">
            {{ $translations['registration_notification']['footer_text'] }}
        </p>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">
            {{ str_replace(':datetime', now()->format('d/m/Y H:i:s'), $translations['registration_notification']['date_time']) }}
        </p>
    </div>
@endsection 