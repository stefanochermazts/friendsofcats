@extends('emails.layouts.brand')

@section('content')
    <h1 class="title">{{ $translations['contact_confirmation']['title'] }}</h1>

    <p class="lead">{{ str_replace(':name', $contact->name, $translations['contact_confirmation']['greeting']) }}</p>
    <p class="muted">{{ $translations['contact_confirmation']['message'] }}</p>

    <div class="info">
        <h3 class="title" style="font-size:16px; margin:0 0 10px;">{{ $translations['contact_confirmation']['details_title'] }}</h3>
        <div style="margin-bottom:10px;"><strong>{{ $translations['contact_confirmation']['subject_label'] }}:</strong> {{ $contact->subject }}</div>
        <div style="margin-bottom:10px;">
            <strong>{{ $translations['contact_confirmation']['message_label'] }}:</strong>
            <p class="muted" style="margin:5px 0 0;">{{ $contact->message }}</p>
        </div>
        <div><strong>{{ $translations['contact_confirmation']['date'] }}:</strong> {{ $contact->created_at->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="info" style="margin-top:20px;">
        <p class="muted" style="margin:0;">{{ $translations['contact_confirmation']['response_time'] }}</p>
    </div>
@endsection 