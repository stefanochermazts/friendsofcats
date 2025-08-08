<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AssociationSearchController extends Controller
{
    /**
     * Ricerca associazioni con filtro per nome
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string|min:2|max:100',
            'page' => 'nullable|integer|min:1|max:100'
        ]);

        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = 20;

        $query = User::where('role', 'associazione')
                    ->where('association_details_completed', true)
                    ->whereNotNull('ragione_sociale');

        // Filtro di ricerca con %substr%
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('ragione_sociale', 'ILIKE', '%' . $search . '%')
                  ->orWhere('citta', 'ILIKE', '%' . $search . '%')
                  ->orWhere('provincia', 'ILIKE', '%' . $search . '%')
                  ->orWhere('name', 'ILIKE', '%' . $search . '%');
            });
        }

        // Ordinamento per rilevanza e alfabetico
        if (!empty($search)) {
            $query->orderByRaw("
                CASE 
                    WHEN ragione_sociale ILIKE ? THEN 1
                    WHEN ragione_sociale ILIKE ? THEN 2
                    WHEN citta ILIKE ? THEN 3
                    ELSE 4
                END,
                ragione_sociale ASC
            ", [
                $search . '%',        // Inizia con
                '%' . $search . '%',  // Contiene
                '%' . $search . '%'   // Città contiene
            ]);
        } else {
            $query->orderBy('ragione_sociale', 'asc');
        }

        $associazioni = $query->select([
                'id',
                'ragione_sociale', 
                'name',
                'citta',
                'provincia',
                'telefono'
            ])
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $associazioni->items(),
            'current_page' => $associazioni->currentPage(),
            'has_more_pages' => $associazioni->hasMorePages(),
            'per_page' => $associazioni->perPage(),
            'total' => $associazioni->total(),
            'last_page' => $associazioni->lastPage()
        ]);
    }

    /**
     * Ottiene dettagli associazione specifica
     */
    public function show(User $association): JsonResponse
    {
        if ($association->role !== 'associazione') {
            return response()->json(['error' => 'Not an association'], 404);
        }

        return response()->json([
            'id' => $association->id,
            'ragione_sociale' => $association->ragione_sociale,
            'name' => $association->name,
            'citta' => $association->citta,
            'provincia' => $association->provincia,
            'telefono' => $association->telefono,
            'descrizione' => $association->descrizione,
            'sito_web' => $association->sito_web,
            'indirizzo_completo' => trim(
                $association->indirizzo . 
                ($association->citta ? ', ' . $association->citta : '') .
                ($association->cap ? ' ' . $association->cap : '') .
                ($association->provincia ? ' (' . $association->provincia . ')' : '')
            )
        ]);
    }
}