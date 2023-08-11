<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use App\Models\UserSpecialRole;

trait HasPermissionsTrait {

    public function givePermissionsTo(... $permissions) 
    {

        $permissions = $this->getAllPermissions($permissions);
        
        if($permissions === null) {

            return $this;

        }

        $this->permissions()->saveMany($permissions);
        return $this;

    }

    public function withdrawPermissionsTo( ... $permissions ) 
    {

        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;

    }

    public function refreshPermissions( ... $permissions ) 
    {

        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);

    }

    public function hasPermissionTo($permission) 
    {

        return $this->hasPermissionThroughRole($permission) || $this->hasPermissionThroughSpecialRole($permission);

    }

    public function hasPermissionThroughRole($permission) 
    {

        foreach ($permission->roles as $role){

            if($this->userGroup->group->roles->contains($role)) {

                return true;

            }
        }

        return false;
    }

    public function hasPermissionThroughSpecialRole($permission) 
    {

        $specialRole = $this->specialRole();
        foreach ($permission->roles as $role){
            
            if( $specialRole->where('id', $role->id) ) {

                return true;

            }

        }

        return false;
    }

    public function roles() 
    {

        return $this->belongsToMany(Role::class,'users_roles');

    }

    public function permissions() 
    {

        return $this->belongsToMany(Permission::class,'users_permissions');

    }

    public function hasRole( ... $roles ) {

        foreach ($roles as $role) {

            if ($this->roles->contains('slug', $role)) {

                return true;
            }
        }

        return false;
    }

    protected function hasPermission($permission) 
    {

        return (bool) $this->permissions->where('slug', $permission->slug)->count();

    }

    protected function getAllPermissions(array $permissions) 
    {

        return Permission::whereIn('slug',$permissions)->get();

    }

    protected function getAllRoles(array $roles)
    {

        return Role::whereIn('slug',$roles)->get();

    }

}