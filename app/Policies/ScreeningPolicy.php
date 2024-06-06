<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScreeningPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type === 'A') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Screening $screening): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Screening $screening): bool
    {
    }

    public function delete(User $user, Screening $screening): bool
    {
    }

    public function restore(User $user, Screening $screening): bool
    {
    }

    public function forceDelete(User $user, Screening $screening): bool
    {
    }
}
