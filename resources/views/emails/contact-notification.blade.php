@extends('emails.layouts.minimal')

@section('content')
    <h1 style="margin: 0 0 20px 0; font-size: 24px; color: #000000;">
        @if($isAdoptionRequest)
            {{ $translations['contact_notification']['adoption_title'] ?? '🐱 Richiesta di adozione' }}
            @if($catName)
                <span style="color: #f97316;">({{ $catName }})</span>
            @endif
        @else
            {{ $translations['contact_notification']['title'] ?? '📧 Nuovo messaggio di contatto' }}
        @endif
    </h1>
    
    <div style="margin-bottom: 20px;">
        <p style="font-size: 16px; margin: 0 0 15px 0;">
            @if($isAdoptionRequest)
                {{ $translations['contact_notification']['adoption_subtitle'] ?? 'Qualcuno è interessato ad adottare uno dei tuoi gatti!' }}
            @else
                {{ $translations['contact_notification']['subtitle'] ?? 'Hai ricevuto un nuovo messaggio tramite il form di contatto.' }}
            @endif
        </p>
        
        <p style="font-size: 14px; line-height: 1.6; margin: 0;">
            @if($isAdoptionRequest)
                {{ $translations['contact_notification']['adoption_message'] ?? 'Ecco i dettagli della richiesta di adozione:' }}
            @else
                {{ $translations['contact_notification']['message'] ?? 'Ecco i dettagli del messaggio ricevuto:' }}
            @endif
        </p>
    </div>
    
    <div class="user-details">
        <h3 style="margin: 0 0 15px 0; font-size: 18px; color: #000000;">
            {{ $translations['contact_notification']['contact_details'] ?? 'Dettagli del contatto' }}
        </h3>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['name'] ?? 'Nome' }}:</strong> {{ $contact->name }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['email'] ?? 'Email' }}:</strong> {{ $contact->email }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['subject_label'] ?? 'Oggetto' }}:</strong> {{ $contact->subject }}
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>{{ $translations['contact_notification']['message_label'] ?? 'Messaggio' }}:</strong>
            <p style="margin: 5px 0 0 0; font-size: 14px; line-height: 1.5;">
                {{ $contact->message }}
            </p>
        </div>
        
        <div>
            <strong>{{ $translations['contact_notification']['date'] ?? 'Data' }}:</strong> {{ $contact->created_at->format('d/m/Y H:i:s') }}
        </div>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background-color: {{ $isAdoptionRequest ? '#fef3c7' : '#fff5f5' }}; border: 1px solid {{ $isAdoptionRequest ? '#fbbf24' : '#fed7d7' }}; border-radius: 4px;">
        <p style="margin: 0; font-size: 14px; line-height: 1.6;">
            <strong>{{ $translations['contact_notification']['action_required'] ?? 'Azione richiesta:' }}</strong>
            @if($isAdoptionRequest)
                {{ $translations['contact_notification']['adoption_action_message'] ?? 'Rispondi a questa richiesta di adozione il prima possibile.' }}
            @else
                {{ $translations['contact_notification']['action_message'] ?? 'Rispondi a questo messaggio quando possibile.' }}
            @endif
        </p>
    </div>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e5e5;">
        <p style="margin: 0; font-size: 12px; color: #666;">
            {{ $translations['contact_notification']['footer_text'] ?? 'Questo messaggio è stato inviato automaticamente dal sistema CatFriends Club.' }}
        </p>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">
            {{ str_replace(':datetime', now()->format('d/m/Y H:i:s'), $translations['contact_notification']['date_time'] ?? 'Ricevuto il :datetime') }}
        </p>
    </div>
@endsection 