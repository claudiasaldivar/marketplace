<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }
}
