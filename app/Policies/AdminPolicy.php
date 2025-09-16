<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\Role as RoleName;

class AdminPolicy
{
    public function viewAny(Admin $authAdmin): bool
    {
        return true;
    }

    public function view(Admin $authAdmin, Admin $admin): bool
    {
        return true;
    }

    public function create(Admin $authAdmin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function update(Admin $authAdmin, Admin $admin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN) && !$admin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function delete(Admin $authAdmin, Admin $admin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN) && !$admin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function deleteAny(Admin $authAdmin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function restore(Admin $authAdmin, Admin $admin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN) && !$admin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function restoreAny(Admin $authAdmin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function forceDelete(Admin $authAdmin, Admin $admin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN) && !$admin->roles->contains('name', RoleName::SUPER_ADMIN);
    }

    public function forceDeleteAny(Admin $authAdmin): bool
    {
        return $authAdmin->roles->contains('name', RoleName::SUPER_ADMIN);
    }
}
