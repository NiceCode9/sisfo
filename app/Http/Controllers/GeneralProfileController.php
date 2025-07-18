<?php

namespace App\Http\Controllers;

use App\Models\GeneralProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data profil sekolah (asumsi hanya ada 1 record)
        $profile = GeneralProfile::first();

        return view('master.profile_sekolah.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.profile_sekolah.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'nama_kepsek' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'map' => 'nullable|string',
            'visi' => 'required|string',
            'misi' => 'required|array|min:1', // Changed to array
            'misi.*' => 'required|string', // Each misi item must be string
            'tahun_berdiri' => 'required|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'sosmed.facebook' => 'nullable|url',
            'sosmed.instagram' => 'nullable|url',
            'sosmed.youtube' => 'nullable|url',
            'sosmed.twitter' => 'nullable|url',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('profile/logo', 'public');
            $data['logo'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('profile/favicon', 'public');
            $data['favicon'] = $faviconPath;
        }

        // Handle sosmed array
        $data['sosmed'] = [
            'facebook' => $request->input('sosmed.facebook'),
            'instagram' => $request->input('sosmed.instagram'),
            'youtube' => $request->input('sosmed.youtube'),
            'twitter' => $request->input('sosmed.twitter'),
        ];

        // Handle misi array - filter out empty values
        $data['misi'] = array_filter($request->input('misi', []), function ($value) {
            return !empty(trim($value));
        });

        GeneralProfile::create($data);

        return redirect()->route('general-profile.index')
            ->with('success', 'Profil sekolah berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralProfile $generalProfile)
    {
        // return view('admin.profile.show', compact('generalProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneralProfile $generalProfile)
    {
        // return view('admin.profile.edit', compact('generalProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralProfile $generalProfile)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'nama_kepsek' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'map' => 'nullable|string',
            'visi' => 'required|string',
            'misi' => 'required|array|min:1', // Changed to array
            'misi.*' => 'required|string', // Each misi item must be string
            'tahun_berdiri' => 'required|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'sosmed.facebook' => 'nullable|url',
            'sosmed.instagram' => 'nullable|url',
            'sosmed.youtube' => 'nullable|url',
            'sosmed.twitter' => 'nullable|url',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($generalProfile->logo) {
                Storage::disk('public')->delete($generalProfile->logo);
            }
            $logoPath = $request->file('logo')->store('profile/logo', 'public');
            $data['logo'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($generalProfile->favicon) {
                Storage::disk('public')->delete($generalProfile->favicon);
            }
            $faviconPath = $request->file('favicon')->store('profile/favicon', 'public');
            $data['favicon'] = $faviconPath;
        }

        // Handle sosmed array
        $data['sosmed'] = [
            'facebook' => $request->input('sosmed.facebook'),
            'instagram' => $request->input('sosmed.instagram'),
            'youtube' => $request->input('sosmed.youtube'),
            'twitter' => $request->input('sosmed.twitter'),
        ];

        // Handle misi array - filter out empty values
        $data['misi'] = array_filter($request->input('misi', []), function ($value) {
            return !empty(trim($value));
        });

        $generalProfile->update($data);

        return redirect()->route('general-profile.index')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(GeneralProfile $generalProfile)
    // {
    //     // Delete logo and favicon files
    //     if ($generalProfile->logo) {
    //         Storage::disk('public')->delete($generalProfile->logo);
    //     }
    //     if ($generalProfile->favicon) {
    //         Storage::disk('public')->delete($generalProfile->favicon);
    //     }

    //     $generalProfile->delete();

    //     return redirect()->route('profile.index')
    //         ->with('success', 'Profil sekolah berhasil dihapus.');
    // }
}
