<?php

namespace App\Policies;

use App\Utils\Roles;
use App\Models\User;

class ScheduleRequestPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return auth()->user()->hasRole(Roles::User);
    }
}
