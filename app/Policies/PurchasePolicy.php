<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return  $user->type === 'A' || $user->type === 'C';
    }

    public function view(User $user, Purchase $purchase): bool
    {
        return ($user->type === 'C' && $user->id === $purchase->customer_id) || $user->type === 'A';
    }
}
