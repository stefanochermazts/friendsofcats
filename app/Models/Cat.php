<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'razza',
        'eta',
        'sesso',
        'peso',
        'colore',
        'stato_sanitario',
        'microchip',
        'numero_microchip',
        'sterilizzazione',
        'vaccinazioni',
        'comportamento',
        'livello_socialita',
        'note_comportamentali',
        'disponibile_adozione',
        'data_arrivo',
        'data_adozione',
        'foto_principale',
        'galleria_foto',
        'user_id', // Chi ha creato/gestisce il gatto
        'associazione_id', // Per associazioni che gestiscono il gatto
    ];

    protected $casts = [
        'eta' => 'integer',
        'peso' => 'decimal:2',
        'sterilizzazione' => 'boolean',
        'disponibile_adozione' => 'boolean',
        'data_arrivo' => 'date',
        'data_adozione' => 'date',
        'vaccinazioni' => 'array',
        'galleria_foto' => 'array',
    ];

    /**
     * Relazione con l'utente che gestisce il gatto
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione con l'associazione (se gestito da associazione)
     */
    public function associazione(): BelongsTo
    {
        return $this->belongsTo(User::class, 'associazione_id');
    }

    /**
     * Scope per gatti disponibili per adozione
     */
    public function scopeDisponibiliAdozione($query)
    {
        return $query->where('disponibile_adozione', true)
                    ->whereNull('data_adozione');
    }

    /**
     * Scope per gatti già adottati
     */
    public function scopeAdottati($query)
    {
        return $query->where('disponibile_adozione', false)
                    ->whereNotNull('data_adozione');
    }

    /**
     * Scope per filtro per razza
     */
    public function scopeRazza($query, $razza)
    {
        return $query->where('razza', $razza);
    }

    /**
     * Scope per filtro per età
     */
    public function scopeEta($query, $etaMin = null, $etaMax = null)
    {
        if ($etaMin) {
            $query->where('eta', '>=', $etaMin);
        }
        if ($etaMax) {
            $query->where('eta', '<=', $etaMax);
        }
        return $query;
    }

    /**
     * Scope per livello di socialità
     */
    public function scopeSocialita($query, $livello)
    {
        return $query->where('livello_socialita', $livello);
    }

    /**
     * Calcola l'età in formato leggibile
     */
    public function getEtaFormattataAttribute(): string
    {
        if ($this->eta < 12) {
            return $this->eta . ' ' . trans_choice('cats.months', $this->eta);
        }
        
        $anni = intval($this->eta / 12);
        $mesi = $this->eta % 12;
        
        if ($mesi === 0) {
            return $anni . ' ' . trans_choice('cats.years', $anni);
        }
        
        return $anni . ' ' . trans_choice('cats.years', $anni) . ' ' . __('cats.and') . ' ' . $mesi . ' ' . trans_choice('cats.months', $mesi);
    }

    /**
     * Get stato sterilizzazione in formato leggibile
     */
    public function getSterilizzazioneTestoAttribute(): string
    {
        return $this->sterilizzazione ? 'Sterilizzato' : 'Non sterilizzato';
    }
}