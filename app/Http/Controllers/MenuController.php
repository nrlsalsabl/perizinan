<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $menus = Menu::query()
            ->where('nama_menu', 'LIKE', "%{$search}%")
            ->orWhere('caption', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $menus = Menu::all();
        return view('menus.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'caption' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'urutan' => 'required|integer',
        ]);

        Menu::create($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $menus = Menu::all();
        return view('menus.edit', compact('menu', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'caption' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'urutan' => 'required|integer',
        ]);

        $menu->update($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }
}

