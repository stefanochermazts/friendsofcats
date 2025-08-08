@extends('emails.layouts.brand')

@section('content')
    <h1 class="title">{{ $translations['verification']['welcome'] }}</h1>

    <p class="lead">{{ str_replace(':name', $userName, $translations['verification']['greeting']) }}</p>
    <p class="muted">{{ $translations['verification']['message'] }}</p>

    <div class="btn-wrap">
        <a href="{{ $verificationUrl }}" class="btn">{{ $translations['verification']['verify_button'] }}</a>
    </div>

    <div class="info">
        <p class="muted" style="margin:0;">
            {{ $translations['verification']['manual_link_text'] }}<br>
            <a href="{{ $verificationUrl }}" style="color:#111827;">{{ $verificationUrl }}</a>
        </p>
    </div>

    <div class="divider"></div>

    <p class="muted" style="margin:0;">
        <strong>{{ $translations['verification']['security_note_title'] }}</strong>
        {{ $translations['verification']['security_note_text'] }}
    </p>
@endsection 