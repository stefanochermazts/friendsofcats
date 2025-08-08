@extends('emails.layouts.brand')

@section('content')
    <h1 class="title">
        @if($isAdoptionRequest)
            {{ $translations['contact_notification']['adoption_title'] ?? '🐱 Richiesta di adozione' }}
            @if($catName)
                <span style="color:#f97316;">({{ $catName }})</span>
            @endif
        @else
            {{ $translations['contact_notification']['title'] ?? '📧 Nuovo messaggio di contatto' }}
        @endif
    </h1>

    <p class="lead">
        @if($isAdoptionRequest)
            {{ $translations['contact_notification']['adoption_subtitle'] ?? 'Qualcuno è interessato ad adottare uno dei tuoi gatti!' }}
        @else
            {{ $translations['contact_notification']['subtitle'] ?? 'Hai ricevuto un nuovo messaggio tramite il form di contatto.' }}
        @endif
    </p>
    <p class="muted">
        @if($isAdoptionRequest)
            {{ $translations['contact_notification']['adoption_message'] ?? 'Ecco i dettagli della richiesta di adozione:' }}
        @else
            {{ $translations['contact_notification']['message'] ?? 'Ecco i dettagli del messaggio ricevuto:' }}
        @endif
    </p>

    <div class="info">
        <h3 class="title" style="font-size:18px; margin:0 0 15px;">{{ $translations['contact_notification']['contact_details'] ?? 'Dettagli del contatto' }}</h3>
        <div style="margin-bottom:10px;"><strong>{{ $translations['contact_notification']['name'] ?? 'Nome' }}:</strong> {{ $contact->name }}</div>
        <div style="margin-bottom:10px;"><strong>{{ $translations['contact_notification']['email'] ?? 'Email' }}:</strong> {{ $contact->email }}</div>
        <div style="margin-bottom:10px;"><strong>{{ $translations['contact_notification']['subject_label'] ?? 'Oggetto' }}:</strong> {{ $contact->subject }}</div>
        <div style="margin-bottom:10px;">
            <strong>{{ $translations['contact_notification']['message_label'] ?? 'Messaggio' }}:</strong>
            <p class="muted" style="margin:5px 0 0;">{{ $contact->message }}</p>
        </div>
        <div><strong>{{ $translations['contact_notification']['date'] ?? 'Data' }}:</strong> {{ $contact->created_at->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="info" style="margin-top:20px; background: {{ $isAdoptionRequest ? '#fef3c7' : '#fff5f5' }}; border-color: {{ $isAdoptionRequest ? '#fbbf24' : '#fed7d7' }};">
        <p class="muted" style="margin:0;">
            <strong>{{ $translations['contact_notification']['action_required'] ?? 'Azione richiesta:' }}</strong>
            @if($isAdoptionRequest)
                {{ $translations['contact_notification']['adoption_action_message'] ?? 'Rispondi a questa richiesta di adozione il prima possibile.' }}
            @else
                {{ $translations['contact_notification']['action_message'] ?? 'Rispondi a questo messaggio quando possibile.' }}
            @endif
        </p>
    </div>
@endsection 