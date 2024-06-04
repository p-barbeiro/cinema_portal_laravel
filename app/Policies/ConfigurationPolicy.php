<?php

namespace App\Policies;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigurationPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type === 'A') {
            return true;
        }
        return null;
    }

    public function view(User $user, Configuration $configuration): bool
    {
        return false;
    }

    public function update(User $user, Configuration $configuration): bool
    {
        return false;
    }

}
