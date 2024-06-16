<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;

class ScreeningPolicy
{
    public function viewAny(User $user): bool
    {
        return $user?->type === 'A' || $user?->type === 'E';
    }

    public function view(?User $user, Screening $screening): bool
    {
        if($user?->type === 'A' || $user?->type === 'E') {
            return true;
        }

        if ($screening->start_time < now()->addMinutes(5)->format('H:i') &&
            $screening->date == now()->format('Y-m-d') || $screening->isSoldOut()) {
            return false;
        }
        return true;
    }

    public function create(User $user): bool
    {
        return $user?->type === 'A';
    }

    public function update(User $user, Screening $screening): bool
    {
        return $user?->type === 'A' && $screening->date >= now()->format('Y-m-d') && $screening->start_time > now() || $user?->type === 'A' && $screening->tickets->count() === 0;;
    }

    public function delete(User $user, Screening $screening): bool
    {
        return $user?->type === 'A' && $screening->date >= now()->format('Y-m-d') && $screening->start_time > now() || $user?->type === 'A' && $screening->tickets->count() === 0;
    }

    public function verify(User $user, Screening $screening): bool
    {
        if($user->type === 'E') {
            return true;
        }

        return false;
    }

    public function verifyTicket(User $user, Screening $screening): bool
    {
        $validating = session('screening', null);

        if($validating === null) {
            return false;
        }

        if($validating['id'] === $screening->id && $user->type === 'E') {
            return true;
        }

        return false;
    }
}
