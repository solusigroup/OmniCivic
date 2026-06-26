<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['branch', 'roles'])->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::all();
        $roles = Role::all();
        return view('users.create', compact('branches', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'branch_id' => 'nullable|exists:branches,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if ($user->id === 999999) {
            return redirect()->route('users.index')->with('error', 'Superadmin default tidak dapat diedit.');
        }

        $branches = Branch::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'branches', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === 999999) {
            return redirect()->route('users.index')->with('error', 'Superadmin default tidak dapat diedit.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|exists:roles,name',
            'branch_id' => 'nullable|exists:branches,id',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'branch_id' => $request->branch_id,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === 999999) {
            return redirect()->route('users.index')->with('error', 'Superadmin default tidak dapat dihapus.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
