<?php

use App\Models\Role;

interface RoleRepository
{
    public static function createWithAbilities($request);
    public function updateWithAbilities(Role $role, $request);
    public function destroy($id);
    public function getRoleAbilities(Role $role);
}
