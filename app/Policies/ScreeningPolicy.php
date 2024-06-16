<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;

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
        return true;
    }

    public function view(?User $user, Screening $screening): bool
    {
        if ($screening->start_time < now()->addMinutes(5)->format('H:i') && $screening->date == now()->format('Y-m-d') || $screening->isSoldOut()) {
            return false;
        }
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Screening $screening): bool
    {
        return false;
    }

    public function delete(User $user, Screening $screening): bool
    {
        return false;
    }
}
