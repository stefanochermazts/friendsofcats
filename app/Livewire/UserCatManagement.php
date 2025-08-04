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
    public $data_arrivo = '';
    public $data_adozione = '';
    public $foto_principale;
    public $galleria_foto = [];

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
        'data_arrivo' => 'nullable|date',
        'data_adozione' => 'nullable|date',
        'foto_principale' => 'nullable|image|max:2048',
        'galleria_foto.*' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->data_arrivo = today()->format('Y-m-d');
        
        // Per i proprietari, di default i gatti non sono disponibili per adozione
        if (auth()->user()->role === 'proprietario') {
            $this->disponibile_adozione = false;
        }
    }

    public function render()
    {
        $cats = Cat::where('user_id', auth()->id())->with('user')
            ->when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%');
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
        $this->resetForm();
        
        if ($catId) {
            $this->editingCat = Cat::where('user_id', auth()->id())->findOrFail($catId);
            $this->loadCatData();
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

        // Gestione upload galleria foto
        if ($this->galleria_foto && count($this->galleria_foto) > 0) {
            $galleryPaths = [];
            foreach ($this->galleria_foto as $foto) {
                $galleryPaths[] = $foto->store('cats/gallery', 'public');
            }
            $data['galleria_foto'] = $galleryPaths;
        } elseif ($this->editingCat && $this->editingCat->galleria_foto) {
            // Mantieni la galleria esistente se non ne sono state caricate nuove
            $data['galleria_foto'] = $this->editingCat->galleria_foto;
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

    public function toggleAdoption($catId)
    {
        $cat = Cat::where('user_id', auth()->id())->findOrFail($catId);
        $cat->update([
            'disponibile_adozione' => !$cat->disponibile_adozione,
            'data_adozione' => !$cat->disponibile_adozione ? now() : null,
        ]);

        $status = $cat->disponibile_adozione ? 'disponibile' : 'adottato';
        session()->flash('success', "Stato di '{$cat->nome}' cambiato in: {$status}!");
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
        
        // Default adozione basato sul ruolo
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
        $this->data_arrivo = $cat->data_arrivo?->format('Y-m-d');
        $this->data_adozione = $cat->data_adozione?->format('Y-m-d');
        // Non carichiamo le foto esistenti nel form per evitare conflitti
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterRazza()
    {
        $this->resetPage();
    }

    public function updatedFilterDisponibile()
    {
        $this->resetPage();
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
        if ($cat->user && $cat->user->role === 'proprietario') {
            return [
                'testo' => __('cats.owned'),
                'classe' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
            ];
        }

        if ($cat->disponibile_adozione) {
            return [
                'testo' => __('cats.available'),
                'classe' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            ];
        }

        if ($cat->data_adozione) {
            return [
                'testo' => __('cats.adopted'),
                'classe' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300'
            ];
        }

        return [
            'testo' => __('cats.evaluating'),
            'classe' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
        ];
    }


}