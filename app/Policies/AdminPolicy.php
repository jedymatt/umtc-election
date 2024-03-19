<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(Admin $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return bool
     */
    public function view(Admin $user, Admin $admin)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Admin $admin)
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Admin $admin)
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Admin $admin)
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Admin $admin)
    {
        return $user->is_super_admin;
    }
}
