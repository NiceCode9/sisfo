<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Load relationships based on user role
        if ($user->isAdmin()) {
            return view('profile.admin', compact('user'));
        } elseif ($user->isGuru()) {
            $user->load('guru.mataPelajaran');
            return view('profile.guru', compact('user'));
        } elseif ($user->isSiswa()) {
            // Load siswa relationships dengan error handling
            $user->load([
                'siswa.calonSiswa',
                'siswa.tahunAjaran',
                'siswa.kelasAwal',
                'siswa.riwayatKelas.kelas',
                'siswa.pengumpulanTugas.tugas'
            ]);
            return view('profile.siswa', compact('user'));
        }

        // Default profile view
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        try {
            if ($user->isAdmin()) {
                return $this->updateAdminProfile($request);
            } elseif ($user->isGuru()) {
                return $this->updateGuruProfile($request);
            } elseif ($user->isSiswa()) {
                return $this->updateSiswaProfile($request);
            }

            return $this->updateBasicProfile($request);
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update admin profile
     */
    private function updateAdminProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $request->user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'fb' => ['nullable', 'url', 'max:255'],
            'ig' => ['nullable', 'url', 'max:255'],
            'x' => ['nullable', 'url', 'max:255'],
            'li' => ['nullable', 'url', 'max:255'],
        ]);

        $user = $request->user();
        $user->fill($request->only(['name', 'username', 'email', 'bio', 'fb', 'ig', 'x', 'li']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update guru profile
     */
    private function updateGuruProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $request->user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'fb' => ['nullable', 'url', 'max:255'],
            'ig' => ['nullable', 'url', 'max:255'],
            'x' => ['nullable', 'url', 'max:255'],
            'li' => ['nullable', 'url', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'biografi' => ['nullable', 'string', 'max:2000'],
            'bidang_keahlian' => ['nullable', 'string', 'max:500'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'gelar' => ['nullable', 'string', 'max:100'],
            'telp' => ['nullable', 'string', 'max:20'],
            'foto_path' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $user = $request->user();
        $user->fill($request->only(['name', 'username', 'email', 'bio', 'fb', 'ig', 'x', 'li']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update guru specific data
        if ($user->guru) {
            $guruData = $request->only(['nip', 'biografi', 'bidang_keahlian', 'alamat', 'gelar', 'telp']);

            // Handle photo upload
            if ($request->hasFile('foto_path')) {
                // Delete old photo
                if ($user->guru->foto_path) {
                    Storage::delete($user->guru->foto_path);
                }

                $path = $request->file('foto_path')->store('guru-photos', 'public');
                $guruData['foto_path'] = $path;
            }

            $user->guru->update($guruData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update siswa profile
     */
    private function updateSiswaProfile(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'bio.max' => 'Bio maksimal 1000 karakter.',
            'fb.url' => 'URL Facebook tidak valid.',
            'ig.url' => 'URL Instagram tidak valid.',
            'x.url' => 'URL Twitter/X tidak valid.',
            'li.url' => 'URL LinkedIn tidak valid.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $request->user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'fb' => ['nullable', 'url', 'max:255'],
            'ig' => ['nullable', 'url', 'max:255'],
            'x' => ['nullable', 'url', 'max:255'],
            'li' => ['nullable', 'url', 'max:255'],
        ], $messages);

        $user = $request->user();
        $user->fill($request->only(['name', 'username', 'email', 'bio', 'fb', 'ig', 'x', 'li']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Note: Siswa data (NIS, NISN, etc.) biasanya tidak dapat diubah oleh siswa
        // Hanya admin yang dapat mengubah data tersebut

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update basic profile (fallback)
     */
    private function updateBasicProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $request->user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $user = $request->user();
        $user->fill($request->only(['name', 'username', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $messages = [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ];

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], $messages);

        try {
            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);

            return Redirect::route('profile.edit')->with('status', 'password-updated');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Gagal memperbarui password.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'Password wajib diisi untuk konfirmasi.',
            'password.current_password' => 'Password tidak sesuai.',
        ]);

        $user = $request->user();

        try {
            Auth::logout();
            $user->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('status', 'Akun berhasil dihapus.');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Gagal menghapus akun.');
        }
    }
}
