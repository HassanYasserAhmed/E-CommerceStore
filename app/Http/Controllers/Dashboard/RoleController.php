<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreRoleRequest;
use App\Http\Requests\Web\UpdateRoleRequest;
use App\Models\Role;
use RoleRepository;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected RoleRepository $roleRepository
    ) {}
    public function index()
    {
        $roles = Role::paginate();

        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles.create', [
            'role' => new Role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->roleRepository->createWithAbilities($request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
       $roleAbilities = $this->roleRepository->getRoleAbilities($role);

        return view('dashboard.roles.edit', compact('role', 'role_abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleRepository->updateWithAbilities($role, $request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->roleRepository->destroy($id);

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
