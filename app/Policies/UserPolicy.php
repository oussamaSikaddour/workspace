<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function onlyOwner(User $user,User $model):bool{
        return $user->is($model);
    }

    public function isAdmin(User $user): bool
{
    return $user->roles->contains('slug', 'admin');
}
    public function isUser(User $user): bool
{
    return $user->roles->contains('slug', 'user');
}

public function isSuperAdmin(User $user): bool
{
    return $user->roles->contains('slug', 'super_admin');
}
public function isApprover(User $user): bool
{
    return $user->roles->contains('slug', 'approver');
}




}
