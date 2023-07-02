<?php

namespace App\Policies;

use App\Models\Parameter_nilai_instansi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParameterNilaiInstansiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Parameter_nilai_instansi $parameterNilaiInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Parameter_nilai_instansi $parameterNilaiInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Parameter_nilai_instansi $parameterNilaiInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Parameter_nilai_instansi $parameterNilaiInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Parameter_nilai_instansi $parameterNilaiInstansi): bool
    {
        //
    }
}
