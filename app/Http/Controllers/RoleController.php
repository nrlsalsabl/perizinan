<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk mendapatkan role
        $query = Role::query();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Mendapatkan data role dengan paginasi
        $roles = $query->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        // Menampilkan form tambah role
        return view('roles.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'required|string|max:255',
            'daftar_akses' => 'required|array', // Ubah ke array jika data daftar_akses berupa array
            'proses_izin' => 'nullable|string',
            'use_pin' => 'string',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $roles = new Role;
            $roles->name = $request->name;
            $roles->description = $request->description;
            $roles->daftar_akses = implode(',', $request->daftar_akses); // Gabung array menjadi string
            $roles->proses_izin = $request->proses_izin;
            $roles->use_pin = $request->use_pin; // Pastikan boolean

            $roles->save();

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }
    }


    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     // Validasi input
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:roles',
    //         'description' => 'required|string|max:255',
    //         'daftar_akses' => 'required|string',
    //         'proses_izin' => 'nullable|string',
    //         'use_pin' => 'boolean',
    //         // 'action_list' => 'nullable',
    //     ]);

    //     $role = new Role();
    //     $role->name = $request->name;
    //     $role->daftar_akses = implode(',', $request->daftar_akses); // Gabung array menjadi string
    //     $role->save();


    //     // Menyimpan role baru
    //     // Role::create($request->all());

    //     return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    // }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'required|string|max:255',
            'daftar_akses' => 'required|string',
            'proses_izin' => 'nullable|string',
            'use_pin' => 'boolean',
        ]);

        // Update data role
        $role->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
