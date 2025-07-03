<?php

namespace App\Http\Controllers;

use App\Models\pengajuanPermohonan;
use App\Models\JenisIzin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PengajuanPermohonanController extends Controller
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
        $jenis_izin = JenisIzin::all();
        return view('pengajuan-permohonan.create', compact('jenis_izin'));
    }

    public function store(Request $request)
{
    $pengajuan = pengajuanPermohonan::where([
        ['dinas_badan', $request->dinas_badan],
        ['jenis_izin', $request->jenis_izin],
        ['jenis_permohonan', $request->jenis_permohonan],
    ])->first();

    if (!$pengajuan) {
        $pengajuan = pengajuanPermohonan::create([
            'dinas_badan' => $request->dinas_badan,
            'jenis_izin' => $request->jenis_izin,
            'jenis_permohonan' => $request->jenis_permohonan,
        ]);
    }

    $request->session()->put('pengajuan_id', $pengajuan->id);

    return redirect()->route('data-pemohon.show')->with('success', 'Data perizinan created successfully.');
}


    public function get_jenisizin(Request $request)
    {
        $jenis_izin = JenisIzin::select('id', DB::raw('nama_jenis_izin'))
            ->get();

        $results = [
            'status' => 'success',
            'data' => $jenis_izin,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }
    /**
     * Display the specified resource.
     */
    public function show(pengajuanPermohonan $pengajuanPermohonan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pengajuanPermohonan $pengajuanPermohonan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pengajuanPermohonan $pengajuanPermohonan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pengajuanPermohonan $pengajuanPermohonan)
    {
        //
    }
}
