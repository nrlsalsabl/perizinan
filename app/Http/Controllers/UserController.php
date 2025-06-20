<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk mendapatkan users
        $query = User::query();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('username', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Mendapatkan data users dengan paginasi
        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }

    public function registrasiIndex()
    {
        return view('register');
    }

    public function registrasiEdit($id)
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    public function registrasiUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Update data user
        $user->update([
            'nik' => $request->nik,
            'npwp' => $request->npwp,
            'username' => $request->username,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'phone' => $request->phone,
            'kode_pos' => $request->kode_pos,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }
        return redirect()->route('dashboard')->with('success', 'User berhasil diperbarui.');
    }


    public function create()
    {
        $roles = Role::all(); // Mendapatkan semua role
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'username' => 'nullable|string|max:255',
            'nik' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kabupaten_kota' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'npwp' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'password' => 'nullable|string|min:6',
            'nip' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            // 'role_id' => 'nullable|array',
        ]);

        // Membuat user baru
        $user = User::create([
            'username' => $request->username,
            'nik' => $request->nik,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'kode_pos' => $request->kode_pos,
            'npwp' => $request->npwp,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'phone' => $request->phone,
        ]);

        // Menambahkan roles pada user
        // $user->roles()->sync($request->role_id);

        return redirect()->route('dashboard')->with('success', 'User berhasil ditambahkan.');
    }

    public function registrasi(Request $request)
    {
        try {
            // Debug incoming request
            Log::info('Registration attempt with data:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'nik' => 'required|string|unique:users',
                'provinsi' => 'nullable|string',
                'kabupaten_kota' => 'nullable|string',
                'kecamatan' => 'nullable|string',
                'alamat' => 'required|string',
                'phone' => 'required|string',
                'kode_pos' => 'required|string',
                'npwp' => 'nullable|string',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            Log::info('Validation passed');

            // Membuat user baru dengan jabatan 'user'
            $user = User::create([
                'username' => $validated['username'],
                'nik' => $validated['nik'],
                'provinsi' => $validated['provinsi'],
                'kabupaten_kota' => $validated['kabupaten_kota'],
                'kecamatan' => $validated['kecamatan'],
                'alamat' => $validated['alamat'],
                'phone' => $validated['phone'],
                'no_hp' => $validated['phone'], // Also set no_hp field
                'kode_pos' => $validated['kode_pos'],
                'npwp' => $validated['npwp'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'jabatan' => 'user', // Set default role to 'user'
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            // Get the user role
            $userRole = Role::where('name', 'user')->first();
            if (!$userRole) {
                // Create user role if it doesn't exist
                $userRole = Role::create([
                    'name' => 'user',
                    'description' => 'Regular user role',
                ]);
                Log::info('Created new user role', ['role_id' => $userRole->id]);
            }

            // Assign the user role
            $user->roles()->attach($userRole->id);
            Log::info('Role attached to user', ['user_id' => $user->id, 'role_id' => $userRole->id]);

            return redirect()->route('perizinan-online')
                ->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error during registration', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error during registration', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Mendapatkan semua role
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->nik = $request->nik;
        $user->npwp = $request->npwp;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->provinsi = $request->provinsi;
        $user->kabupaten_kota = $request->kabupaten_kota;
        $user->kecamatan = $request->kecamatan;
        $user->phone = $request->phone;
        $user->kode_pos = $request->kode_pos;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;

        // Only update password if filled
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
