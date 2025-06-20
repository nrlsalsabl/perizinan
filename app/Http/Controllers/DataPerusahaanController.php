<?php

namespace App\Http\Controllers;

use App\Models\dataPerusahaan;
use App\Http\Controllers\Controller;
use App\Models\BentukPerusahaan;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DataPerusahaanController extends Controller
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
        return view('data-perusahaan.create');
    }

    public function store(Request $request)
    {
        // dd(session()->all());
        // $request->validate([
        //     'kode_jenis_layanan' => 'required|string',
        //     'nama_jenis_layanan' => 'required|string',
        //     'alias' => 'required|string',

        // ]);
        // $step1Data = $request->session()->get('storePengajuan', []);
        // $step2Data = $request->session()->get('storePemohon', []);
        $pemohonId = $request->session()->get('pemohon_id');
        $provinsi = Provinsi::find($request->provinsi);
        $kabupaten = KabupatenKota::find($request->kabupaten);
        $kecamatan = Kecamatan::find($request->kecamatan);
        $request->merge(['provinsi' => $provinsi->nama]);
        $request->merge(['kabupaten' => $kabupaten->nama]);
        $request->merge(['kecamatan' => $kecamatan->nama]);

        // Simpan data pemohon ke database
        $perusahaan =  dataPerusahaan::create([
            'pemohon_id' => $pemohonId,
            'nib' => $request->nib,
            'npwp' => $request->npwp,
            'npwd' => $request->npwd,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'bentuk_perusahaan' => $request->bentuk_perusahaan,
            'status_perusahaan' => $request->status_perusahaan,
            'phone' => $request->phone,
            'kode_pos' => $request->kode_pos,
        ]);

        $request->session()->put('perusahaan_id', $perusahaan->id);


        // $request->session()->put('storePerusahaan', array_merge($step1Data, $step2Data, [
        //     'pemohon_id' => $step2Data['id'] ?? null,
        //     'nib' => $request->nib,
        //     'npwp' => $request->npwp,
        //     'npwd' => $request->npwd,
        //     'name' => $request->name,
        //     'alamat' => $request->alamat,
        //     'provinsi' => $request->provinsi,
        //     'kabupaten_kota' => $request->kabupaten_kota,
        //     'kecamatan' => $request->kecamatan,
        //     'bentuk_perusahaan' => $request->bentuk_perusahaan,
        //     'status_perusahaan' => $request->status_perusahaan,
        //     'phone' => $request->phone,
        //     'kode_pos' => $request->kode_pos,
        // ]));

        // dataPerusahaan::create($request->all());

        return redirect()->route('lokasi-izin.show')->with('success', 'Data perizinan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $step1Data = $request->session()->get('storePengajuan');
        // $step2Data = $request->session()->get('storePemohon');

        return view('data-perusahaan.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dataPerusahaan $dataPerusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, dataPerusahaan $dataPerusahaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dataPerusahaan $dataPerusahaan)
    {
        //
    }

    public function get_bentukperusahaan(Request $request)
    {
        // dd($request->all());
        $bentuk = BentukPerusahaan::select('id', 'bentuk_perusahaan')
            ->get();
        // $bentuk = DB::table('bentuk_perusahaans')->select('bentuk_perusahaan');
        // dd($bentuk);
        $results = [
            'status' => 'success',
            'data' => $bentuk,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }
}
