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
    // Cek apakah session lokasi dan pengajuan tersedia
    if (!$request->session()->has('lokasi_id') || !$request->session()->has('pengajuan_id')) {
        return redirect()->route('lokasi-izin.create')->with('error', 'Lengkapi data lokasi dan pengajuan terlebih dahulu.');
    }

    // Validasi input dan file
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

    // Ambil dari session
    $lokasiId = $request->session()->get('lokasi_id');
    $pengajuanId = $request->session()->get('pengajuan_id');

    // Upload semua file
    $uploaded = [];
    foreach ([
        'surat_permohonan', 'ktp_dir', 'nib_oss', 'izin_usaha',
        'akta_per', 'profil_per', 'npwp_kaltim', 'surat_domisili',
        'sertif_badan', 'rencana_peng', 'surat_pene', 'sertif_kompeten',
        'sertif_iso', 'sop', 'peralatan_sewa', 'surat_kuasa'
    ] as $field) {
        $uploaded[$field] = $request->file($field)->store('', 'public');
    }

    // Simpan data detail lampiran
    $lampiran = dataDetail::create(array_merge([
        'lokasi_id' => $lokasiId,
        'tgl_permohonan' => $request->tgl_permohonan,
        'nomor_surat' => $request->nomor_surat,
        'nama' => $request->nama,
        'jenis_usaha' => $request->jenis_usaha,
    ], $uploaded));

    // Dapatkan info pemohon dan pengajuan
    $pemohon = dataPemohon::where('pengajuan_id', $pengajuanId)->first();
    $pengajuan = pengajuanPermohonan::find($pengajuanId);

    // Cek apakah sudah ada requestPendaftaran sebelumnya
    $existing = requestPendaftaran::where('pengajuan_id', $pengajuanId)->first();

    if (!$existing) {
        requestPendaftaran::create([
            'resi' => strtoupper(Str::random(8)), // ✅ Format resmi & konsisten
            'nama_pemohon' => $pemohon->name,
            'pengajuan_id' => $pengajuanId,
            'user_id' => Auth::id(),
            'jenis_izin' => $pengajuan->jenis_izin,
            'jenis_permohonan' => $pengajuan->jenis_permohonan,
            'proses_terakhir' => 'Pendaftaran',
            'role' => 'Front Office',
            'verification_status' => 'pending'
        ]);
    }

    // Bersihkan session agar tidak reuse
    $request->session()->forget(['pengajuan_id', 'lokasi_id']);

    // Redirect ke detail
    return redirect()->route('data-lampiran.detail', $lampiran->id)
        ->with('success', '✅ Data berhasil disimpan.');
}


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

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

  public function detail($id)
{
    $lampiran = dataDetail::findOrFail($id);
    return view('data-lampiran.detail', compact('lampiran'));
}



}
