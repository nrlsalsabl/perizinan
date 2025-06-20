<?php

namespace App\Http\Controllers;

use App\Models\AccountPemohon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('perizinan-online');  // Pastikan ini sesuai dengan nama file view Anda
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        dd($request->all());
        // Validasi form input
        $validate = Validator::make($request->all(), [
            'nik' => 'required|string',
            'npwp' => 'nullable|string',
            'name' => 'required',
            'alamat' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'kode_pos' => 'required|string',
            'email' => 'required|string',
            'kode_email' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $regist = new AccountPemohon;
            $regist->nik = $request->nik;
            $regist->npwp = $request->npwp;
            $regist->name = $request->name;
            $regist->alamat = $request->alamat;
            $regist->provinsi = $request->provinsi;
            $regist->kota = $request->kota;
            $regist->kecamatan = $request->kecamatan;
            $regist->kelurahan = $request->kelurahan;
            $regist->kode_pos = $request->kode_pos;
            $regist->phone = $request->phone;
            $regist->last_login = $request->last_login;
            $regist->email = $request->email;
            $user->password = bcrypt($request->password);

            $regist->save();

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }

        // Cek apakah kode email sesuai
        // if ($request->kode_email != Session::get('kode_email')) {
        //     return back()->with('error', 'Kode email tidak valid.');
        // }

        // Hapus kode dari sesi
        // Session::forget('kode_email');


    }

    // Simpan kode email di sesi
    public function saveCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        // Simpan kode di session
        Session::put('kode_email', $request->code);

        // Kirim email kode verifikasi (opsional)
        Mail::raw('Kode verifikasi Anda adalah: ' . $request->code, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Kode Verifikasi Email');
        });

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'daftar_akses' => 'required|array',
            'proses_izin' => 'nullable|string',
            'use_pin' => 'nullable|boolean',
            'action_list' => 'required|array',
        ]);

        // Simpan role
        Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'daftar_akses' => $request->daftar_akses,
            'proses_izin' => $request->proses_izin,
            'use_pin' => $request->use_pin,
            'action_list' => $request->action_list,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    /**
     * Display the password reset link request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
