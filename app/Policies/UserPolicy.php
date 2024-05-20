<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MDepartment;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    public function myTicket(User $user)
    {
        return $user->role != 'admin';
    }

    public function produksiType(User $user)
    {
        if ($user->role == 'atasan teknisi') {
            return $user->pegawai->department->name == 'IT' ? true : false;
        } else {
            return true;
        }
    }
    public function itType(User $user)
    {
        if ($user->role == 'atasan teknisi') {
            return $user->pegawai->department->name == 'Engineering' ? true : false;
        } else {
            return true;
        }
    }
}
