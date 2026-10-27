<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InnovationProject;
use Illuminate\Auth\Access\HandlesAuthorization;

class InnovationProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_innovation::project');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InnovationProject $innovationProject): bool
    {
        return $user->can('view_innovation::project');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_innovation::project');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InnovationProject $innovationProject): bool
    {
        return $user->can('update_innovation::project');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InnovationProject $innovationProject): bool
    {
        return $user->can('delete_innovation::project');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_innovation::project');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, InnovationProject $innovationProject): bool
    {
        return $user->can('force_delete_innovation::project');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_innovation::project');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, InnovationProject $innovationProject): bool
    {
        return $user->can('restore_innovation::project');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_innovation::project');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, InnovationProject $innovationProject): bool
    {
        return $user->can('replicate_innovation::project');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_innovation::project');
    }
}
