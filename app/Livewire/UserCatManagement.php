<?php

namespace App\Livewire;

use App\Models\Cat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class UserCatManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $editingCat = null;
    public $search = '';
    public $filterRazza = '';
    public $filterDisponibile = '';
    
    // Form fields
    public $nome = '';
    public $razza = '';
    public $eta = '';
    public $sesso = '';
    public $peso = '';
    public $colore = '';
    public $stato_sanitario = '';
    public $microchip = false;
    public $numero_microchip = '';
    public $sterilizzazione = false;
    public $vaccinazioni = [];
    public $comportamento = '';
    public $livello_socialita = 'medio';
    public $note_comportamentali = '';
    public $disponibile_adozione = true;
    public $stato = 'di_proprieta';
    public $data_arrivo = '';
    public $data_adozione = '';
    public $foto_principale;
    public $galleria_foto = [];
    public $maxFileSizeMB;
    public $maxFileSizeKB;

    protected $rules = [
        'nome' => 'required|string|max:255',
        'razza' => 'nullable|string|max:255',
        'eta' => 'nullable|integer|min:0|max:300',
        'sesso' => 'nullable|in:maschio,femmina',
        'peso' => 'nullable|numeric|min:0|max:15',
        'colore' => 'nullable|string|max:255',
        'stato_sanitario' => 'nullable|string',
        'microchip' => 'boolean',
        'numero_microchip' => 'nullable|string|max:255',
        'sterilizzazione' => 'boolean',
        'comportamento' => 'nullable|string',
        'livello_socialita' => 'required|in:basso,medio,alto',
        'note_comportamentali' => 'nullable|string',
        'disponibile_adozione' => 'boolean',
        'stato' => 'required|in:di_proprieta,adottabile,non_adottabile,adottato',
        'data_arrivo' => 'nullable|date',
        'data_adozione' => 'nullable|date',
        'foto_principale' => 'nullable|image|max:2048',
        'galleria_foto.*' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->data_arrivo = today()->format('Y-m-d');
        $this->maxFileSizeMB = $this->getMaxUploadSizeMB(); // per la view
        $this->maxFileSizeKB = $this->maxFileSizeMB * 1024; // per la validazione
        
        // Default stato e disponibilità basati sul ruolo
        if (auth()->user()->role === 'proprietario') {
            $this->disponibile_adozione = false;
            $this->stato = 'di_proprieta';
        } else {
            $this->disponibile_adozione = true;
            $this->stato = 'adottabile';
        }
    }

    private function getMaxUploadSizeMB()
    {
        $size = ini_get('upload_max_filesize');
        $unit = strtolower(substr(trim($size), -1));
        $value = (float) $size;
        
        switch ($unit) {
            case 'g':
                $value *= 1024;
                break;
            case 'k':
                $value = $value / 1024;
                break;
            // 'm' is già MB
        }
        
        return max(1, (int) round($value));
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'razza' => 'nullable|string|max:255',
            'eta' => 'nullable|integer|min:0|max:300',
            'sesso' => 'nullable|in:maschio,femmina',
            'peso' => 'nullable|numeric|min:0|max:15',
            'colore' => 'nullable|string|max:255',
            'stato_sanitario' => 'nullable|string',
            'microchip' => 'boolean',
            'numero_microchip' => 'nullable|string|max:255',
            'sterilizzazione' => 'boolean',
            'comportamento' => 'nullable|string',
            'livello_socialita' => 'required|in:basso,medio,alto',
            'note_comportamentali' => 'nullable|string',
            'disponibile_adozione' => 'boolean',
            'stato' => 'required|in:di_proprieta,adottabile,non_adottabile,adottato',
            'data_arrivo' => 'nullable|date',
            'data_adozione' => 'nullable|date',
            'foto_principale' => 'nullable|image|max:' . $this->maxFileSizeKB,
            'galleria_foto.*' => 'nullable|image|max:' . $this->maxFileSizeKB,
        ];
    }

    public function render()
    {
        $cats = Cat::where('user_id', auth()->id())->with('user')
            ->when($this->search, function ($query) {
                $searchTerm = strtolower($this->search);
                $query->whereRaw('LOWER(nome) LIKE ?', ['%' . $searchTerm . '%']);
            })
            ->when($this->filterRazza, function ($query) {
                $query->where('razza', $this->filterRazza);
            })
            ->when($this->filterDisponibile !== '', function ($query) {
                $query->where('disponibile_adozione', $this->filterDisponibile);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $razze = Cat::where('user_id', auth()->id())
            ->distinct()
            ->pluck('razza')
            ->filter()
            ->sort();

        // Ottieni razze tradotte e ordinate
        $breedsArray = __('cats.breeds');
        asort($breedsArray); // Ordina alfabeticamente per valore
        
        return view('livewire.user-cat-management', compact('cats', 'razze', 'breedsArray'));
    }

    public function openModal($catId = null)
    {
        logger('OpenModal called with catId: ' . $catId);
        
        $this->resetForm();
        
        if ($catId) {
            $this->editingCat = Cat::where('user_id', auth()->id())->findOrFail($catId);
            $this->loadCatData();
            logger('Loading cat data for: ' . $this->editingCat->nome);
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingCat = null;
        $this->resetForm();
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'razza' => $this->razza ?: null,
            'eta' => $this->eta ?: null,
            'sesso' => $this->sesso ?: null,
            'peso' => $this->peso ?: null,
            'colore' => $this->colore ?: null,
            'stato_sanitario' => $this->stato_sanitario ?: null,
            'microchip' => $this->microchip,
            'numero_microchip' => $this->numero_microchip ?: null,
            'sterilizzazione' => $this->sterilizzazione,
            'vaccinazioni' => $this->vaccinazioni ?: [],
            'comportamento' => $this->comportamento ?: null,
            'livello_socialita' => $this->livello_socialita,
            'note_comportamentali' => $this->note_comportamentali ?: null,
            'disponibile_adozione' => $this->disponibile_adozione,
            'stato' => $this->stato,
            'data_arrivo' => $this->data_arrivo ?: null,
            'data_adozione' => $this->data_adozione ?: null, // Fix: stringa vuota → null
            'user_id' => auth()->id(),
        ];

        // Gestione upload foto principale
        if ($this->foto_principale) {
            $data['foto_principale'] = $this->foto_principale->store('cats/main', 'public');
        } elseif ($this->editingCat && $this->editingCat->foto_principale) {
            // Mantieni la foto esistente se non ne è stata caricata una nuova
            $data['foto_principale'] = $this->editingCat->foto_principale;
        }

        // Gestione upload galleria foto - AGGIUNTA alle foto esistenti
        $existingGallery = [];
        if ($this->editingCat && $this->editingCat->galleria_foto && is_array($this->editingCat->galleria_foto)) {
            $existingGallery = $this->editingCat->galleria_foto;
        }

        if ($this->galleria_foto && count($this->galleria_foto) > 0) {
            $newGalleryPaths = [];
            foreach ($this->galleria_foto as $foto) {
                $newGalleryPaths[] = $foto->store('cats/gallery', 'public');
            }
            // Unisci le foto esistenti con quelle nuove
            $data['galleria_foto'] = array_merge($existingGallery, $newGalleryPaths);
        } else {
            // Mantieni la galleria esistente se non ne sono state caricate nuove
            $data['galleria_foto'] = $existingGallery;
        }

        if ($this->editingCat) {
            $this->editingCat->update($data);
            session()->flash('success', "Gatto '{$this->nome}' aggiornato con successo!");
        } else {
            Cat::create($data);
            session()->flash('success', "Gatto '{$this->nome}' creato con successo!");
        }

        $this->closeModal();
    }

    public function deleteCat($catId)
    {
        $cat = Cat::where('user_id', auth()->id())->findOrFail($catId);
        $nome = $cat->nome;
        $cat->delete();
        
        session()->flash('success', "Gatto '{$nome}' eliminato con successo!");
    }

    public function updateStato($catId, $nuovoStato)
    {
        $cat = Cat::where('user_id', auth()->id())->findOrFail($catId);
        
        $updateData = ['stato' => $nuovoStato];
        
        // Aggiorna i campi legacy per compatibilità
        switch ($nuovoStato) {
            case 'adottabile':
                $updateData['disponibile_adozione'] = true;
                $updateData['data_adozione'] = null;
                break;
            case 'adottato':
                $updateData['disponibile_adozione'] = false;
                $updateData['data_adozione'] = now();
                break;
            case 'di_proprieta':
            case 'non_adottabile':
                $updateData['disponibile_adozione'] = false;
                $updateData['data_adozione'] = null;
                break;
        }
        
        $cat->update($updateData);

        $statoLabels = [
            'di_proprieta' => __('cats.owned'),
            'adottabile' => __('cats.available'),
            'non_adottabile' => __('cats.not_available'),
            'adottato' => __('cats.adopted')
        ];

        session()->flash('success', "Stato di '{$cat->nome}' cambiato in: {$statoLabels[$nuovoStato]}!");
    }

    private function resetForm()
    {
        $this->nome = '';
        $this->razza = '';
        $this->eta = '';
        $this->sesso = '';
        $this->peso = '';
        $this->colore = '';
        $this->stato_sanitario = '';
        $this->microchip = false;
        $this->numero_microchip = '';
        $this->sterilizzazione = false;
        $this->vaccinazioni = [];
        $this->comportamento = '';
        $this->livello_socialita = 'medio';
        $this->note_comportamentali = '';
        $this->data_arrivo = today()->format('Y-m-d');
        $this->data_adozione = '';
        $this->foto_principale = null;
        $this->galleria_foto = [];
        
        // Default stato basato sul ruolo
        $this->stato = auth()->user()->role === 'proprietario' ? 'di_proprieta' : 'adottabile';
        $this->disponibile_adozione = auth()->user()->role !== 'proprietario';
    }

    private function loadCatData()
    {
        $cat = $this->editingCat;
        $this->nome = $cat->nome;
        $this->razza = $cat->razza;
        $this->eta = $cat->eta;
        $this->sesso = $cat->sesso;
        $this->peso = $cat->peso;
        $this->colore = $cat->colore;
        $this->stato_sanitario = $cat->stato_sanitario;
        $this->microchip = $cat->microchip;
        $this->numero_microchip = $cat->numero_microchip;
        $this->sterilizzazione = $cat->sterilizzazione;
        $this->vaccinazioni = $cat->vaccinazioni ?? [];
        $this->comportamento = $cat->comportamento;
        $this->livello_socialita = $cat->livello_socialita;
        $this->note_comportamentali = $cat->note_comportamentali;
        $this->disponibile_adozione = $cat->disponibile_adozione;
        $this->stato = $cat->stato ?? 'di_proprieta';
        $this->data_arrivo = $cat->data_arrivo?->format('Y-m-d');
        $this->data_adozione = $cat->data_adozione?->format('Y-m-d');
        // Non carichiamo le foto esistenti nel form per evitare conflitti
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->dispatch('refreshComponent');
    }

    public function updatedFilterRazza()
    {
        $this->resetPage();
        $this->dispatch('refreshComponent');
    }

    public function updatedFilterDisponibile()
    {
        $this->resetPage();
        $this->dispatch('refreshComponent');
    }

    /**
     * Ottieni il numero totale di foto per un gatto
     */
    public function getTotalPhotos($cat)
    {
        $count = 0;
        if ($cat->foto_principale) $count++;
        if ($cat->galleria_foto && is_array($cat->galleria_foto)) {
            $count += count($cat->galleria_foto);
        }
        return $count;
    }

    /**
     * Ottieni tutte le foto di un gatto (principale + galleria)
     */
    public function getAllPhotos($cat)
    {
        $photos = [];
        
        if ($cat->foto_principale) {
            $photos[] = $cat->foto_principale;
        }
        
        if ($cat->galleria_foto && is_array($cat->galleria_foto)) {
            $photos = array_merge($photos, $cat->galleria_foto);
        }
        
        return $photos;
    }

    /**
     * Restituisce il metodo getStatoGatto per la vista
     */
    public function getStatoGatto($cat)
    {
        $statoMap = [
            'di_proprieta' => [
                'testo' => __('cats.owned'),
                'classe' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
            ],
            'adottabile' => [
                'testo' => __('cats.available'),
                'classe' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            ],
            'non_adottabile' => [
                'testo' => __('cats.not_available'),
                'classe' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
            ],
            'adottato' => [
                'testo' => __('cats.adopted'),
                'classe' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300'
            ]
        ];

        return $statoMap[$cat->stato] ?? $statoMap['di_proprieta'];
    }

    /**
     * Rimuove una foto specifica dalla galleria
     */
    public function removeGalleryPhoto($photoIndex)
    {
        if ($this->editingCat && isset($this->editingCat->galleria_foto[$photoIndex])) {
            $galleria = $this->editingCat->galleria_foto;
            
            // Rimuovi la foto dall'array
            unset($galleria[$photoIndex]);
            
            // Riordina l'array per evitare indici sparsi
            $galleria = array_values($galleria);
            
            // Aggiorna il gatto
            $this->editingCat->update(['galleria_foto' => $galleria]);
            
            session()->flash('success', __('cats.gallery_photo_removed'));
        }
    }


}
