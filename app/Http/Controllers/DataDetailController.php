<?php

namespace App\Http\Controllers;

use App\Models\dataDetail;
use App\Http\Controllers\Controller;
use App\Models\dataPemohon;
use App\Models\dataPerusahaan;
use App\Models\lokasiIzin;
use App\Models\pengajuanPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\requestPendaftaran;
use Illuminate\Support\Facades\Auth;

class DataDetailController extends Controller
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
    public function create(Request $request)
    {
        if (!$request->session()->has('lokasi_id') || !$request->session()->has('pengajuan_id')) {
            return redirect()->route('lokasi-izin.create')->with('error', 'Lengkapi data lokasi dan pengajuan terlebih dahulu.');
        }
        return view('data-lampiran.create');
    }

    public function store(Request $request)
    {
        if (!$request->session()->has('lokasi_id') || !$request->session()->has('pengajuan_id')) {
            return redirect()->route('lokasi-izin.create')->with('error', 'Lengkapi data lokasi dan pengajuan terlebih dahulu.');
        }
        $request->validate([
            'tgl_permohonan' => 'required|date',
            'nomor_surat' => 'required|string',
            'nama' => 'required|string',
            'jenis_usaha' => 'required|string',
            'surat_permohonan' => 'required|file|mimes:pdf',
            'ktp_dir' => 'required|file|mimes:pdf',
            'nib_oss' => 'required|file|mimes:pdf',
            'izin_usaha' => 'required|file|mimes:pdf',
            'akta_per' => 'required|file|mimes:pdf',
            'profil_per' => 'required|file|mimes:pdf',
            'npwp_kaltim' => 'required|file|mimes:pdf',
            'surat_domisili' => 'required|file|mimes:pdf',
            'sertif_badan' => 'required|file|mimes:pdf',
            'rencana_peng' => 'required|file|mimes:pdf',
            'surat_pene' => 'required|file|mimes:pdf',
            'sertif_kompeten' => 'required|file|mimes:pdf',
            'sertif_iso' => 'required|file|mimes:pdf',
            'sop' => 'required|file|mimes:pdf',
            'peralatan_sewa' => 'required|file|mimes:pdf',
            'surat_kuasa' => 'required|file|mimes:pdf',
        ]);

        $lokasiId = $request->session()->get('lokasi_id');
        $pengajuanId = $request->session()->get('pengajuan_id');

        $path1 = $request->file('surat_permohonan') ?  $request->file('surat_permohonan')->store('', 'public') : null;
        $path2 = $request->file('ktp_dir') ?  $request->file('ktp_dir')->store('', 'public') : null;
        $path3 = $request->file('nib_oss') ? $request->file('nib_oss')->store('', 'public') : null;
        $path4 =  $request->file('izin_usaha') ? $request->file('izin_usaha')->store('', 'public') : null;
        $path5 =  $request->file('akta_per') ? $request->file('akta_per')->store('', 'public') : null;
        $path6 =  $request->file('profil_per') ? $request->file('profil_per')->store('', 'public') : null;
        $path7 =  $request->file('npwp_kaltim') ? $request->file('npwp_kaltim')->store('', 'public') : null;
        $path8 =  $request->file('surat_domisili') ? $request->file('surat_domisili')->store('', 'public') : null;
        $path9 =  $request->file('sertif_badan') ? $request->file('sertif_badan')->store('', 'public') : null;
        $path10 =  $request->file('rencana_peng') ? $request->file('rencana_peng')->store('', 'public') : null;
        $path11 =  $request->file('surat_pene') ? $request->file('surat_pene')->store('', 'public') : null;
        $path12 =  $request->file('sertif_kompeten') ? $request->file('sertif_kompeten')->store('', 'public') : null;
        $path13 =  $request->file('sertif_iso') ? $request->file('sertif_iso')->store('', 'public') : null;
        $path14 =  $request->file('sop') ? $request->file('sop')->store('', 'public') : null;
        $path15 =  $request->file('peralatan_sewa') ? $request->file('peralatan_sewa')->store('', 'public') : null;
        $path16 =  $request->file('surat_kuasa') ? $request->file('surat_kuasa')->store('', 'public') : null;

        $lampiran = dataDetail::create([
            'lokasi_id' => $lokasiId,
            'tgl_permohonan' => $request->tgl_permohonan,
            'nomor_surat' => $request->nomor_surat,
            'nama' => $request->nama,
            'jenis_usaha' => $request->jenis_usaha,
            'surat_permohonan' => $path1 ?? 'no file',
            'ktp_dir' => $path2 ?? 'no file',
            'nib_oss' => $path3 ?? 'no file',
            'izin_usaha' => $path4 ?? 'no file',
            'akta_per' => $path5 ?? 'no file',
            'profil_per' => $path6 ?? 'no file',
            'npwp_kaltim' => $path7 ?? 'no file',
            'surat_domisili' => $path8 ?? 'no file',
            'sertif_badan' => $path9 ?? 'no file',
            'rencana_peng' => $path10 ?? 'no file',
            'surat_pene' => $path11 ?? 'no file',
            'sertif_kompeten' => $path12 ?? 'no file',
            'sertif_iso' => $path13 ?? 'no file',
            'sop' => $path14 ?? 'no file',
            'peralatan_sewa' => $path15 ?? 'no file',
            'surat_kuasa' => $path16 ?? 'no file',
        ]);

        // Get related data for creating verification request
        $pemohon = dataPemohon::where('pengajuan_id', $pengajuanId)->first();
        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->first();
        $pengajuan = pengajuanPermohonan::find($pengajuanId);

        // Create verification request for Front Office
        requestPendaftaran::create([
            'resi' => 'RESI-' . strtoupper(Str::random(8)),
            'nama_pemohon' => $pemohon->name,
            'pengajuan_id' => $pengajuanId,
            'user_id' => Auth::id(),
            'jenis_izin' => $pengajuan->jenis_izin,
            'jenis_permohonan' => $pengajuan->jenis_permohonan,
            'proses_terakhir' => 'Pendaftaran',
            'role' => 'Front Office',
            'verification_status' => 'pending'
        ]);

        $request->session()->flush();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'redirect' => route('dashboard')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $step1Data = $request->session()->get('storePengajuan');
        // $step2Data = $request->session()->get('storePemohon');
        // $step3Data = $request->session()->get('storePerusahaan');
        // $step4Data = $request->session()->get('storeLokasi');

        return view('data-lampiran.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dataDetail $dataDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, dataDetail $dataDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dataDetail $dataDetail)
    {
        //
    }
}
