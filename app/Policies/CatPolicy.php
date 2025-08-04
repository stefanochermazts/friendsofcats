<?php

namespace App\Policies;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CatPolicy
{
    /**
     * Area admin: solo admin può accedere
     * Area utente: tutti gli altri ruoli 
     */
    private function canAccessCatsAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
    
    private function canAccessCatsUser(User $user): bool
    {
        return in_array($user->role, ['associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore']);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin può vedere tutti i gatti nell'area admin
        if ($this->canAccessCatsAdmin($user)) {
            return true;
        }
        
        // Altri ruoli possono vedere nell'area utente
        return $this->canAccessCatsUser($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cat $cat): bool
    {
        // Admin può vedere tutti i gatti nell'area admin
        if ($this->canAccessCatsAdmin($user)) {
            return true;
        }
        
        // Area utente: ogni ruolo vede solo i propri gatti
        if ($this->canAccessCatsUser($user)) {
            return $cat->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin può creare nell'area admin
        if ($this->canAccessCatsAdmin($user)) {
            return true;
        }
        
        // Altri ruoli possono creare nell'area utente
        return $this->canAccessCatsUser($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cat $cat): bool
    {
        // Admin può modificare tutti i gatti nell'area admin
        if ($this->canAccessCatsAdmin($user)) {
            return true;
        }
        
        // Area utente: ogni ruolo può modificare solo i propri gatti
        if ($this->canAccessCatsUser($user)) {
            return $cat->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cat $cat): bool
    {
        // Admin può eliminare tutti i gatti nell'area admin
        if ($this->canAccessCatsAdmin($user)) {
            return true;
        }
        
        // Area utente: ogni ruolo può eliminare solo i propri gatti
        if ($this->canAccessCatsUser($user)) {
            return $cat->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cat $cat): bool
    {
        return $this->delete($user, $cat);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cat $cat): bool
    {
        return $this->delete($user, $cat);
    }
}