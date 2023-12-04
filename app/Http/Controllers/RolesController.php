<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // abort_if(Gate::denies('Akses Admin'), Response::HTTP_FORBIDDEN, response()->json(['error' => 'Forbidden']));
        abort_if(Gate::denies('Akses Admin'), Response::HTTP_FORBIDDEN, 'forbidden');
        $roles = Role::all();

        return view('pages.backend.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('pages.backend.role.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);
        alert()->success('Success','Role has been created');
        return redirect()->route('roles.index');
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
        $permissions = Permission::all();
        $rolePermissionNames = $role->permissions->pluck('name')->toArray();
        return view('pages.backend.role.edit',compact('role','permissions','rolePermissionNames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $data = $request->all();

    try {
        // Temukan pengguna
        $role = Role::findOrFail($id);
        // Sinkronkan peran pengguna (pastikan $request->roles adalah array)
            $role->syncPermissions($request->permissions);
        // Update pengguna dengan data yang baru

        alert()->success('Success', 'Role has been updated');
        return redirect()->route('roles.index');
    } catch (\Exception $e) {
        // Handle error, misalnya jika pengguna tidak ditemukan
        alert()->error('Error', 'role not found');
        return redirect()->route('roles.index');
    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
