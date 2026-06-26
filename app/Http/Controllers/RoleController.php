<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        if ($role->name === 'super_admin') {
            return redirect()->route('roles.index')->with('error', 'Super Admin role tidak dapat diedit.');
        }

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'super_admin') {
            return redirect()->route('roles.index')->with('error', 'Super Admin role tidak dapat diedit.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['super_admin', 'ketua', 'bendahara', 'staff'])) {
            return redirect()->route('roles.index')->with('error', 'Sistem role default tidak dapat dihapus.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
