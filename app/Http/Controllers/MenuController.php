<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('parent')
            ->orderBy('parent_id')
            ->orderBy('order')
            ->get();

        $parentMenus = Menu::whereNull('parent_id')->get();
        $permissions = Permission::all()->pluck('name', 'name');

        return view('settings.menus.index', compact('menus', 'parentMenus', 'permissions'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->get();
        $permissions = Permission::all()->pluck('name', 'name');

        return view('settings.menus.form', compact('parentMenus', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'permission' => 'nullable|string|exists:permissions,name',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'is_header' => 'boolean',
            'group' => 'nullable|string|max:255',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->get();

        $permissions = Permission::all()->pluck('name', 'name');

        return view('settings.menus.form', compact('menu', 'parentMenus', 'permissions'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'permission' => 'nullable|string|exists:permissions,name',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'is_header' => 'boolean',
            'group' => 'nullable|string|max:255',
        ]);

        // Prevent menu from being its own parent
        if ($validated['parent_id'] == $menu->id) {
            return redirect()->back()
                ->with('error', 'Menu tidak bisa menjadi parent dirinya sendiri');
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return redirect()->route('admin.menus.index')
                ->with('error', 'Menu tidak bisa dihapus karena memiliki submenu');
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus');
    }

    public function updateOrder(Request $request)
    {
        try {
            foreach ($request->order as $order => $id) {
                Menu::where('id', $id)->update(['order' => $order]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan menu berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan menu'
            ], 500);
        }
    }
}
