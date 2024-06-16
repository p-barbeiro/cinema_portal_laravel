<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class UserPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }

    public function view(User $user, User $administrative): bool
    {
        return $user->type == 'A';
    }

    public function create(User $user): bool
    {
        return $user->type == 'A';
    }

    public function update(User $user, User $administrative): bool
    {
        return $user->type == 'A';
    }

    public function updateRole(User $user, User $administrative): bool
    {
        return $user->type == 'A' && $user->id != $administrative->id;
    }

    public function delete(User $user, User $administrative): bool
    {
        return $user->type == 'A' && $user->id != $administrative->id;
    }

}
