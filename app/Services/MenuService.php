<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    public function getSidebarMenu()
    {
        return Menu::with(['children' => function ($query) {
            $query->where('is_active', true)
                ->orderBy('order');
        }])
            ->parents()
            ->orderBy('group')
            ->orderBy('order')
            ->get();
        // ->filter(function ($menu) {
        //     // Filter berdasarkan permission
        //     if ($menu->permission && !Auth::user()->can($menu->permission)) {
        //         return false;
        //     }

        //     // Jika punya children, filter yang punya children aktif
        //     if ($menu->children->count() > 0) {
        //         $menu->children = $menu->children->filter(function ($child) {
        //             return !$child->permission || Auth::user()->can($child->permission);
        //         });

        //         return $menu->children->count() > 0;
        //     }

        //     return true;
        // });
    }

    public function getAllMenus()
    {
        return Menu::with('parent')
            ->orderBy('parent_id')
            ->orderBy('order')
            ->get();
    }

    public function createMenu(array $data)
    {
        return Menu::create([
            'name' => $data['name'],
            'icon' => $data['icon'] ?? null,
            'route' => $data['route'] ?? null,
            'url' => $data['url'] ?? null,
            'permission' => $data['permission'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
            'is_header' => $data['is_header'] ?? false,
        ]);
    }

    public function updateMenu(Menu $menu, array $data)
    {
        $menu->update([
            'name' => $data['name'],
            'icon' => $data['icon'] ?? null,
            'route' => $data['route'] ?? null,
            'url' => $data['url'] ?? null,
            'permission' => $data['permission'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'order' => $data['order'] ?? $menu->order,
            'is_active' => $data['is_active'] ?? $menu->is_active,
            'is_header' => $data['is_header'] ?? $menu->is_header,
        ]);

        return $menu;
    }
}
