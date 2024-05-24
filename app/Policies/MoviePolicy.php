<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;

class MoviePolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
            return true;
        }
        return null;
    }

    public function viewShowCase(?User $user): bool
    {
        return true;
    }
}
