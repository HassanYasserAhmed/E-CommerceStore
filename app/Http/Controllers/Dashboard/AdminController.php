<?php

namespace App\Http\Controllers\Dashboard;

use AdminRepository;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected AdminRepository $adminRepository)
    {
        $this->authorizeResource(Admin::class, 'admin');
    }

    public function index()
    {
        $admins =$this->adminRepository->all();

        return view('dashboard.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
       $admin = $this->adminRepository->findModel($admin);

        return view('dashboard.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
       $data = $this->adminRepository->getEditData($admin);
       
        return view('dashboard.admin.edite', array_merge($data,['admin'=>$admin]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
       $this->adminRepository->syncRoles($admin,$request->roles);

        return redirect()->route('admin.index')->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function trash()
    {
        $admins = $this->adminRepository->getTrashedAdmins();

        return view('dashboard.admin.trash', compact('admins'));
    }
}
