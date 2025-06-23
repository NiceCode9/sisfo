<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('settings.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Permission::select('group')->distinct()->pluck('group');
        return view('settings.permission.form', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'group' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        Permission::create([
            'name' => $validated['name'],
            'group' => $validated['group'],
            'description' => $validated['description'] ?? null,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        $groups = Permission::select('group')->distinct()->pluck('group');
        return view('settings.permission.form', compact('permission', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id)
            ],
            'group' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        $permission->update([
            'name' => $validated['name'],
            'group' => $validated['group'],
            'description' => $validated['description'] ?? null
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permissions.index')
                ->with('error', 'Permission tidak bisa dihapus karena masih digunakan oleh role');
        }

        $permission->delete();
        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil dihapus');
    }
}
