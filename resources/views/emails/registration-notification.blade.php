@extends('emails.layouts.brand')

@section('content')
    <h1 class="title">{{ $translations['registration_notification']['title'] }}</h1>

    <p class="lead">{{ $translations['registration_notification']['subtitle'] }}</p>

    <div class="info">
        <h3 class="title" style="font-size:18px; margin:0 0 15px;">{{ $translations['registration_notification']['user_details'] }}</h3>
        <p><strong>{{ $translations['registration_notification']['name'] }}</strong> {{ $user->name }}</p>
        <p><strong>{{ $translations['registration_notification']['email'] }}</strong> {{ $user->email }}</p>
        <p><strong>{{ $translations['registration_notification']['registration_date'] }}</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
        @if($user->role)
            <p><strong>{{ $translations['registration_notification']['role'] }}</strong> {{ ucfirst($user->role) }}</p>
        @endif
    </div>

    <p class="muted" style="margin-top:20px;">{{ $translations['registration_notification']['success_message'] }}</p>
@endsection 