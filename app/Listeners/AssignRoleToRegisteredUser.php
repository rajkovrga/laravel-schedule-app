<?php

namespace App\Listeners;

use App\Models\User;
use App\Utils\Roles;
use Filament\Events\Auth\Registered;

class AssignRoleToRegisteredUser
{

    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->getUser();
        $user->assignRole(Roles::User);
        $user->refresh();
    }
}
