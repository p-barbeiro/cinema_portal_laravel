<?php

namespace App\Policies;

use App\Models\Theater;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TheaterPolicy
{
    use HandlesAuthorization;
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type === 'A') {
            return true;
        }
        return null;
    }
    public function viewAny(User $user)
    {

    }

    public function view(User $user, Theater $theater)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, Theater $theater)
    {
    }

    public function delete(User $user, Theater $theater)
    {
    }

    public function restore(User $user, Theater $theater)
    {
    }

    public function forceDelete(User $user, Theater $theater)
    {
    }
}
