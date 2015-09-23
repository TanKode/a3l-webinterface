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
        $abilities = $this->listAbilities();
        return $roles->reject(function($role) use ($abilities) {
            if (! $abilities->contains($this->buildRoleAssignmentAbility($role->name))) {
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
        if (is_string($role)) {
            return $role;
        }
        if (is_integer($role)) {
            return Role::find($role)->name;
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
        return 'assign-' . Str::slug($name) . '-role';
    }
}