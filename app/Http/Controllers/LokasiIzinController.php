<?php

namespace App\Http\Controllers;

use App\Models\lokasiIzin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;

class LokasiIzinController extends Controller
{
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
        // $user = Auth::user(); // Mendapatkan data user yang sedang login
        return view('lokasi-izin.create');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'kode_jenis_layanan' => 'required|string',
        //     'nama_jenis_layanan' => 'required|string',
        //     'alias' => 'required|string',

        // ]);
        // $step1Data = $request->session()->get('storePengajuan', []);
        // $step2Data = $request->session()->get('storePemohon', []);
        // $step3Data = $request->session()->get('storePerusahaan', []);

        $perusahaanId = $request->session()->get('perusahaan_id');
        $provinsi = Provinsi::find($request->provinsi);
        $kabupaten = KabupatenKota::find($request->kabupaten);
        $kecamatan = Kecamatan::find($request->kecamatan);
        $request->merge(['provinsi' => $provinsi->nama]);
        $request->merge(['kabupaten' => $kabupaten->nama]);
        $request->merge(['kecamatan' => $kecamatan->nama]);

        // Simpan data pemohon ke database
        $lokasi =  lokasiIzin::create([
            'perusahaan_id' => $perusahaanId,
            'jalan' => $request->jalan,
            'nomor' => $request->nomor,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
        ]);

        $request->session()->put('lokasi_id', $lokasi->id);

        // $request->session()->put('storeLokasi', array_merge($step1Data, $step2Data, $step3Data, [
        //     'perusahaan_id' => $step3Data['id'] ?? null,
        //     'jalan' => $request->jalan,
        //     'nomor' => $request->nomor,
        //     'rt' => $request->rt,
        //     'rw' => $request->rw,
        //     'provinsi' => $request->provinsi,
        //     'kabupaten_kota' => $request->kabupaten_kota,
        //     'kecamatan' => $request->kecamatan,
        // ]));

        // lokasiIzin::create($request->all());

        return redirect()->route('data-lampiran.show')->with('success', 'Data perizinan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $step1Data = $request->session()->get('storePengajuan');
        // $step2Data = $request->session()->get('storePemohon');
        // $step3Data = $request->session()->get('storePerusahaan');

        return view('lokasi-izin.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(lokasiIzin $lokasiIzin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, lokasiIzin $lokasiIzin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(lokasiIzin $lokasiIzin)
    {
        //
    }
}
