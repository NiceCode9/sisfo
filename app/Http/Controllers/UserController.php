<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles', 'siswa'])
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            })
            ->get();

        return view('settings.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        $siswas = Siswa::doesntHave('user')->get();

        return view('settings.users.form', compact('roles', 'siswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'siswa_id' => 'nullable|exists:siswas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'siswa_id' => $request->siswa_id
        ]);

        $roles = Role::whereIn('id', $request->roles)->get();
        $user->syncRoles($roles);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat');
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
        $user = User::findOrFail($id);
        if ($user->hasRole('Super Admin')) {
            abort(403, 'Super Admin tidak bisa diubah');
        }

        $roles = Role::where('name', '!=', 'Super Admin')->get();
        $siswas = Siswa::doesntHave('user')->orWhere('id', $user->siswa_id)->get();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('settings.users.form', compact('user', 'roles', 'siswas', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('Super Admin')) {
            abort(403, 'Super Admin tidak bisa diubah');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'siswa_id' => 'nullable|exists:siswas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'siswa_id' => $request->siswa_id
        ]);

        $roles = Role::whereIn('id', $request->roles)->get();
        $user->syncRoles($roles);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('Super Admin')) {
            abort(403, 'Super Admin tidak bisa dihapus');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Password user berhasil diperbarui');
    }
}
