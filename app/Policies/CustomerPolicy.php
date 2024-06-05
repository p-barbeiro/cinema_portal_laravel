<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
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
        return false;
    }

    public function view(User $user, Customer $customer): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Customer $customer): bool
    {
        return false;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return false;
    }
}
