<?php

namespace App\Http\Controllers;

use App\Models\dataPemohon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Provinsi;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
// use App\Http\Middleware\JabatanMiddleware;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\JenisIzin;
use App\Models\pengajuanPermohonan;
use App\Models\requestPendaftaran;
use App\Models\User;

class DataPemohonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
        return view('data-pemohon.create', compact('user'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd(session()->all());
        // $request->validate([
        //     'kode_jenis_layanan' => 'required|string',
        //     'nama_jenis_layanan' => 'required|string',
        //     'alias' => 'required|string',
        // ]);

        $pengajuanId = $request->session()->get('pengajuan_id');
        $pengajuanPermohonan = pengajuanPermohonan::find($pengajuanId);
        $jenisIzin = $pengajuanPermohonan->jenis_izin;
        $jenisPermohonan = $pengajuanPermohonan->jenis_permohonan;

        // $step1Data = $request->session()->get('storePengajuan', []);
        // $request->session()->put('storePemohon', array_merge($step1Data, [
        //     'pengajuan_id' => $step1Data['id'] ?? null,
        //     'nik' => $request->nik,
        //     'name' => $request->name,
        //     'alamat' => $request->alamat,
        //     'provinsi' => $request->provinsi,
        //     'kabupaten_kota' => $request->kabupaten_kota,
        //     'kecamatan' => $request->kecamatan,
        //     'phone' => $request->phone,
        //     'kode_pos' => $request->kode_pos,
        //     'email' => $request->email,
        // ]));

        $provinsi = Provinsi::find($request->provinsi);
        $kabupaten = KabupatenKota::find($request->kabupaten_kota);
        $kecamatan = Kecamatan::find($request->kecamatan);
        $request->merge(['provinsi' => $provinsi->nama]);
        $request->merge(['kabupaten_kota' => $kabupaten->nama]);
        $request->merge(['kecamatan' => $kecamatan->nama]);

        // Simpan data pemohon ke database
        $pemohon =  dataPemohon::create([
            'pengajuan_id' => $pengajuanId,
            'nik' => $request->nik,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'phone' => $request->phone,
            'kode_pos' => $request->kode_pos,
            'email' => $request->email,
        ]);

        $resi = strtoupper(Str::random(6));
        // Ambil user ID yang login
        $userId = Auth::id(); // atau auth()->id();

        requestPendaftaran::create([
            'resi' => $resi,
            'nama_pemohon' => $request->name,
            'pengajuan_id' => $pengajuanId,
            'user_id' => $userId,
            'jenis_izin' => $jenisIzin,
            'jenis_permohonan' => $jenisPermohonan,
            'proses_terakhir' => 'Pendaftaran',
            'role' => 'Front Office',
            'catatan' => $request->catatan,
        ]);

        $request->session()->put('pemohon_id', $pemohon->id);

        // dataPemohon::create($request->all());

        return redirect()->route('data-perusahaan.show')->with('success', 'Data perizinan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        return view('data-pemohon.create', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dataPemohon $dataPemohon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, dataPemohon $dataPemohon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dataPemohon $dataPemohon)
    {
        //
    }
}
