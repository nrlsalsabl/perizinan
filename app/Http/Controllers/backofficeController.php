<?php

namespace App\Http\Controllers;

use App\Models\dataDetail;
use App\Models\dataPemohon;
use App\Models\dataPerusahaan;
use App\Models\lokasiIzin;
use App\Models\PermohonanIzin;
use App\Models\requestPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class backofficeController extends Controller
{
    public function indexProses()
    {
        $pengajuanIds = requestPendaftaran::select('pengajuan_id')
            ->groupBy('pengajuan_id')
            ->havingRaw('SUM(CASE WHEN role = "Front Office" AND verification_status = "verified" THEN 1 ELSE 0 END) > 0')
            ->havingRaw('SUM(CASE WHEN role = "Kasi" AND verification_status = "verified" THEN 1 ELSE 0 END) > 0')
            ->havingRaw('SUM(CASE WHEN proses_terakhir = "Ditolak" THEN 1 ELSE 0 END) = 0')
            ->havingRaw('SUM(CASE WHEN proses_terakhir = "Selesai" THEN 1 ELSE 0 END) = 0')
            ->pluck('pengajuan_id');

        $latestData = requestPendaftaran::whereIn('pengajuan_id', $pengajuanIds)
            ->where('role', 'Back Office')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('pengajuan_id');

        $perusahaan = dataPerusahaan::all();

        return view('back-office.proses.index', [
            'pendaftaran' => $latestData,
            'perusahaan' => $perusahaan
        ]);
    }

        public function detailPenyerahan($id)
    {
        $pendaftaran = requestPendaftaran::findOrFail($id);
        $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
        $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
        $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();
        return view('back-office.penyerahan-izin.detail', compact('pendaftaran', 'pemohon', 'perusahaan', 'lokasi', 'lampiran'));
    }

    public function detailProses($id)
    {
        $pendaftaran = requestPendaftaran::findOrFail($id);
        $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();

        $foVerified = requestPendaftaran::where('pengajuan_id', $pemohon->pengajuan_id)
            ->where('role', 'Front Office')->where('verification_status', 'verified')->exists();

        $kasiVerified = requestPendaftaran::where('pengajuan_id', $pemohon->pengajuan_id)
            ->where('role', 'Kasi')->where('verification_status', 'verified')->exists();

        if (!$foVerified || !$kasiVerified) {
            return redirect()->route('proses-backoffice.index')->with('error', 'Tahap sebelumnya belum selesai.');
        }

        $sudahVerifikasi = requestPendaftaran::where('pengajuan_id', $pemohon->pengajuan_id)
            ->where('role', 'Back Office')
            ->where('verification_status', 'verified')
            ->exists();

        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
        $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
        $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();

        return view('back-office.proses.detail', compact('pendaftaran', 'pemohon', 'perusahaan', 'lokasi', 'lampiran', 'sudahVerifikasi'));
    }

    public function indexPenyerahan()
{
    $pengajuanIds = requestPendaftaran::select('pengajuan_id')
        ->groupBy('pengajuan_id')
        ->havingRaw('SUM(CASE WHEN role = "Front Office" AND verification_status = "verified" THEN 1 ELSE 0 END) > 0')
        ->havingRaw('SUM(CASE WHEN role = "Kasi" AND verification_status = "verified" THEN 1 ELSE 0 END) > 0')
        ->havingRaw('SUM(CASE WHEN role = "Back Office" AND verification_status = "verified" THEN 1 ELSE 0 END) > 0')
        ->havingRaw('SUM(CASE WHEN proses_terakhir = "Cetak Izin" THEN 1 ELSE 0 END) > 0')
        ->pluck('pengajuan_id');

    $pendaftaran = requestPendaftaran::whereIn('pengajuan_id', $pengajuanIds)
        ->where('proses_terakhir', 'Cetak Izin')
        ->where('role', 'Back Office')
        ->orderByDesc('created_at')
        ->get();

    $perusahaan = dataPerusahaan::all();
    return view('back-office.penyerahan-izin.index', compact('pendaftaran', 'perusahaan'));
}



    public function updateProses(Request $request, $id)
{
    $pendaftaran = requestPendaftaran::findOrFail($id);

    $sudahVerifikasi = requestPendaftaran::where('pengajuan_id', $pendaftaran->pengajuan_id)
        ->where('role', 'Back Office')
        ->where('verification_status', 'verified')
        ->exists();

    if ($sudahVerifikasi) {
        return redirect()->route('proses-backoffice.index')->with('error', 'Verifikasi sudah dilakukan sebelumnya.');
    }

    $files = $request->input('nama_file');
    $valid = $request->input('validasi');
    $catatan_umum = $request->input('catatan_umum');
    $proses_terakhir = $request->input('proses_terakhir');

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
        $pendaftaran->update([
            'verification_status' => 'verified',
            'verified_by' => $userId,
            'verified_at' => now(),
            'proses_terakhir' => 'Proses BackOffice'
        ]);

        $foVerified = requestPendaftaran::where('pengajuan_id', $pemohon->pengajuan_id)
            ->where('role', 'Front Office')->where('verification_status', 'verified')->exists();
        $kasiVerified = requestPendaftaran::where('pengajuan_id', $pemohon->pengajuan_id)
            ->where('role', 'Kasi')->where('verification_status', 'verified')->exists();

        if ($foVerified && $kasiVerified) {
            requestPendaftaran::create([
                'resi' => $request->input('resi'),
                'nama_pemohon' => $request->input('name'),
                'pengajuan_id' => $pemohon->pengajuan_id,
                'user_id' => $userId,
                'jenis_izin' => $request->input('jenis_izin'),
                'jenis_permohonan' => $request->input('jenis_permohonan'),
                'proses_terakhir' => 'Cetak Izin',
                'role' => 'Back Office',
                'verification_status' => 'pending'
            ]);

            // Masukkan ke permohonan_izins juga
            PermohonanIzin::updateOrCreate(
                ['resi' => $request->input('resi')],
                [
                    'nama_pemohon' => $request->input('name'),
                    'jenis_izin_id' => $request->input('jenis_izin_id') ?? null,
                    'jenis_proses_perizinan' => $request->input('jenis_permohonan'),
                    'proses_terakhir' => 'Cetak Izin',
                    'role' => 'Back Office',
                    'catatan' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
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

    return redirect()->route('proses-backoffice.index')->with('success', 'Data berhasil diperbarui!');
}


    public function updatePenyerahan(Request $request, $id)
{
    $pendaftaran = requestPendaftaran::findOrFail($id);
    $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
    $userId = Auth::id();

    // Buat entry di request_pendaftarans sebagai bukti penyerahan
    requestPendaftaran::create([
        'resi' => $request->input('resi'),
        'nama_pemohon' => $request->input('name'),
        'pengajuan_id' => $pemohon->pengajuan_id,
        'user_id' => $userId,
        'jenis_izin' => $request->input('jenis_izin'),
        'jenis_permohonan' => $request->input('jenis_permohonan'),
        'proses_terakhir' => 'Selesai',
        'role' => 'Back Office',
        'verification_status' => 'completed'
    ]);

    PermohonanIzin::create([
    'resi' => $request->input('resi'),
    'nama_pemohon' => $request->input('name'),
    'jenis_izin_id' => $pendaftaran->jenis_izin_id, // ini fix
    'jenis_proses_perizinan' => $request->input('jenis_permohonan'),
    'proses_terakhir' => 'Selesai',
    'role' => 'Back Office',
    'catatan' => null,
]);



    return redirect()->route('penyerahan-izin.index')->with('success', 'Izin berhasil diserahkan!');
}

    public function getVerificationStatus($pengajuanId)
    {
        $roles = ['Front Office', 'Kasi', 'Back Office'];
        $statuses = [];

        foreach ($roles as $role) {
            $latest = requestPendaftaran::where('pengajuan_id', $pengajuanId)
                ->where('role', $role)
                ->when($role === 'Back Office', function ($q) {
                    $q->where('proses_terakhir', 'Proses BackOffice');
                })
                ->orderByDesc('created_at')
                ->first();

            $statuses[strtolower(str_replace(' ', '', $role))] = $latest->verification_status ?? 'Menunggu Verifikasi';
        }

        $statusAkhir = 'Selesai';
        if ($statuses['frontoffice'] !== 'verified') {
            $statusAkhir = 'Menunggu Verifikasi Front Office';
        } elseif ($statuses['kasi'] !== 'verified') {
            $statusAkhir = 'Menunggu Verifikasi Kasi';
        } elseif ($statuses['backoffice'] !== 'verified') {
            $statusAkhir = 'Menunggu Verifikasi Back Office';
        }

        return response()->json([
            'frontoffice' => $statuses['frontoffice'],
            'kasi' => $statuses['kasi'],
            'backoffice' => $statuses['backoffice'],
            'final_status' => $statusAkhir
        ]);
    }
}
