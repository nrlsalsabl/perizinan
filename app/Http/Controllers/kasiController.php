<?php

namespace App\Http\Controllers;

use App\Models\dataDetail;
use App\Models\dataPemohon;
use App\Models\dataPerusahaan;
use App\Models\lokasiIzin;
use App\Models\requestPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class kasiController extends Controller
{
    public function indexVerifikasi()
{
    // Ambil semua pengajuan_id yang tidak ditolak
    $pengajuanIds = requestPendaftaran::select('pengajuan_id')
        ->groupBy('pengajuan_id')
        ->havingRaw('SUM(CASE WHEN proses_terakhir = "Ditolak" THEN 1 ELSE 0 END) = 0')
        ->pluck('pengajuan_id');

    // Ambil hanya data pengajuan yang memiliki role 'Kasi'
    $pendaftaran = requestPendaftaran::whereIn('pengajuan_id', $pengajuanIds)
        ->where('role', 'Kasi')
        ->latest()
        ->get();

    // Tambahkan status verifikasi paralel untuk setiap pengajuan
    foreach ($pendaftaran as $item) {
        $item->status_frontoffice = requestPendaftaran::where('pengajuan_id', $item->pengajuan_id)
            ->where('role', 'Front Office')->latest()->value('proses_terakhir');

        $item->status_kasi = requestPendaftaran::where('pengajuan_id', $item->pengajuan_id)
            ->where('role', 'Kasi')->latest()->value('proses_terakhir');

        $item->status_backoffice = requestPendaftaran::where('pengajuan_id', $item->pengajuan_id)
            ->where('role', 'Back Office')->latest()->value('proses_terakhir');
    }

    return view('kasi.verifikasi.index', compact('pendaftaran'));
}


   public function detailVerifikasi($id)
{
    $pendaftaran = requestPendaftaran::findOrFail($id);
    $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
    $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
    $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
    $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();

    // Tambahan untuk cek apakah Kasi sudah verifikasi
    $sudahVerifikasi = requestPendaftaran::where('pengajuan_id', $pendaftaran->pengajuan_id)
        ->where('role', 'Kasi')
        ->where('proses_terakhir', 'Terverifikasi')
        ->exists();

    return view('kasi.verifikasi.detail', compact('pendaftaran', 'pemohon', 'perusahaan', 'lokasi', 'lampiran', 'sudahVerifikasi'));
}


    public function updateVerifikasi(Request $request, $id)
    {
        $files = $request->input('nama_file');
        $valid = $request->input('validasi');
        $catatan_umum = $request->input('catatan_umum');
        $proses_terakhir = $request->input('proses_terakhir');

        $pendaftaran = requestPendaftaran::findOrFail($id);
        $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
        $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
        $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();
        $userId = Auth::id();

        if ($proses_terakhir === 'Ditolak') {
            $pendaftaran->update([
                'verification_status' => 'rejected',
                'verified_by' => $userId,
                'verified_at' => now(),
                'proses_terakhir' => 'Ditolak',
                'alasan_penolakan' => $request->input('alasan_penolakan')
            ]);
        } else {
            // Buat entry baru untuk backoffice jika verifikasi berhasil
            $pendaftaran->update([
                'verification_status' => 'verified',
                'verified_by' => $userId,
                'verified_at' => now(),
                'proses_terakhir' => 'Terverifikasi'
            ]);

            // Tambahkan entri baru untuk Back Office
            requestPendaftaran::create([
                'resi' => $pendaftaran->resi,
                'nama_pemohon' => $pendaftaran->nama_pemohon,
                'pengajuan_id' => $pendaftaran->pengajuan_id,
                'user_id' => $userId,
                'jenis_izin' => $pendaftaran->jenis_izin,
                'jenis_permohonan' => $pendaftaran->jenis_permohonan,
                'proses_terakhir' => 'Proses BackOffice',
                'role' => 'Back Office',
                'verification_status' => 'pending'
            ]);
        }

        if (count($catatan_umum) === 1) {
            $catatan_umum = array_fill(0, count($files), $catatan_umum[0]);
        }

        foreach ($files as $index => $fileName) {
            DB::table('reject_data')->insert([
                'pengajuan_id' => $pemohon->pengajuan_id,
                'detail_id' => $lampiran->id,
                'nama_file' => $fileName,
                'validasi' => $valid[$index],
                'catatan_umum' => $catatan_umum[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('verifikasi-kasi.index')->with('success', 'Verifikasi Kasi berhasil disimpan!');
    }

    public function getVerificationStatus($pengajuanId)
{
    $statusFront = requestPendaftaran::where('pengajuan_id', $pengajuanId)
        ->where('role', 'Front Office')->latest()->value('proses_terakhir') ?? 'Belum';

    $statusKasi = requestPendaftaran::where('pengajuan_id', $pengajuanId)
        ->where('role', 'Kasi')->latest()->value('proses_terakhir') ?? 'Belum';

    $statusBack = requestPendaftaran::where('pengajuan_id', $pengajuanId)
        ->where('role', 'Back Office')->latest()->value('proses_terakhir') ?? 'Belum';

    return response()->json([
        'frontoffice' => $statusFront,
        'kasi' => $statusKasi,
        'backoffice' => $statusBack,
    ]);
}

}
