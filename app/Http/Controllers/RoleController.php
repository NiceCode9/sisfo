<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('s');
        if ($search) {
            $roles = Role::where('name', 'like', "%$search%")->withCount('users')->paginate(10);
        } else {
            $roles = Role::withCount('users')->paginate(10);
        }

        return view('settings.roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('settings.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (isset($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dibuat');
    }

    public function edit(Role $role)
    {
        if ($role->name === 'Super Admin') {
            abort(403, 'Super Admin role tidak bisa diubah');
        }

        $permissions = Permission::all()->groupBy('group');
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('settings.roles.create', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Super Admin') {
            abort(403, 'Super Admin role tidak bisa diubah');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id)
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update(['name' => $validated['name']]);

        if (isset($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            abort(403, 'Super Admin role tidak bisa dihapus');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak bisa dihapus karena masih memiliki user');
        }

        $role->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
