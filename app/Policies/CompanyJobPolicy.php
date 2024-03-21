<?php

namespace App\Policies;

use App\Utils\Permissions;
use Illuminate\Auth\Access\Response;
use App\Models\CompanyJob;
use App\Models\User;

class CompanyJobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo(Permissions::ViewAllJobs);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CompanyJob $companyjob): bool
    {
        return $user->checkPermissionTo(Permissions::ViewJobs);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo(Permissions::CreateJob);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompanyJob $companyjob): bool
    {
        return $user->checkPermissionTo(Permissions::EditJob);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompanyJob $companyjob): bool
    {
        return $user->checkPermissionTo(Permissions::DeleteJob);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CompanyJob $companyjob): bool
    {
        return $user->checkPermissionTo(Permissions::DeleteJob);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CompanyJob $companyjob): bool
    {
        return $user->checkPermissionTo(Permissions::DeleteJob);
    }
}
