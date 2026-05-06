<?php
namespace App\Repositories\Admin;
use App\Models\Admin;

interface AdminRepository
{
    public function all();
    public function findModel(Admin $admin);
    public function getEditData(Admin $admin);
    public function syncRoles(Admin $admin, array $roles): void;
    public function getTrashedAdmins();
}
