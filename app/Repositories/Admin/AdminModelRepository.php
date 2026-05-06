<?php
namespace App\Repositories\Admin;
use App\Models\Admin;
use App\Models\Role;

class AdminModelRepository implements AdminRepository {
    public function all()
    {
        return Admin::all();
    }
    public function findModel(Admin $admin) {
        return  $admin->load('roles');
    }
     public function getEditData(Admin $admin)
    {
        return [
            'roles' => Role::all(),
            'admin_roles' => $admin->roles()->pluck('id')->toArray(),
        ];
    }
    public function syncRoles(Admin $admin, array $roles): void
    {
        $admin->roles()->sync($roles);
    }
     public function getTrashedAdmins()
    {
        return Admin::onlyTrashed()->get();
    }
}