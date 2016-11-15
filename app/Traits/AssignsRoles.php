<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Silber\Bouncer\Database\Role;

trait AssignsRoles
{
    public function hasRole($role)
    {
        $role = $this->getRoleName($role);
        return $this->roles()->where('name', $role)->exists();
    }

    public function assignableRoles()
    {
        $roles = Role::all();
        $abilities = $this->abilities;
        return $roles->reject(function ($role) use ($abilities) {
            if($this->isSuperAdmin()) {
                return false;
            }
            if (!$abilities->contains($this->buildRoleAssignmentAbility($role->name))) {
                return true;
            };
        });
    }

    public function canAssignRole($role)
    {
        $role = $this->getRoleName($role);
        return $this->can($this->buildRoleAssignmentAbility($role));
    }

    protected function getRoleName($role)
    {
        if (is_integer($role)) {
            return Role::find($role)->name;
        }
        if (is_string($role)) {
            return $role;
        }
        if ($role instanceof Role) {
            return $role->name;
        }
        throw new \RuntimeException('Unable to identify role.');
    }

    public function retractAll()
    {
        $this->roles()->detach();
    }

    protected function buildRoleAssignmentAbility($name)
    {
        return 'manage-' . Str::slug($name) . '-role';
    }
}