<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $pengajuanIds = requestPendaftaran::select('pengajuan_id')
            ->groupBy('pengajuan_id')
            ->havingRaw('SUM(CASE WHEN proses_terakhir = "Ditolak" THEN 1 ELSE 0 END) = 0')
            ->pluck('pengajuan_id');

        $pendaftaran = requestPendaftaran::where('proses_terakhir', 'Proses Kasi')
            ->whereIn('pengajuan_id', $pengajuanIds)
            ->where('role', 'Kasi')
            ->where('verification_status', 'pending')
            ->get();

        $perusahaan = dataPerusahaan::all();
        return view('kasi.verifikasi.index', compact('pendaftaran', 'perusahaan'));
    }

    public function detailVerifikasi($id)
    {
        $pendaftaran = requestPendaftaran::findOrFail($id);
        $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
        $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
        $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();
        // dd($pemohon);
        return view('kasi.verifikasi.detail', compact('pendaftaran', 'pemohon', 'perusahaan', 'lokasi', 'lampiran'));
    }

    // public function storePendaftaran(Request $request)
    // {
    //     requestPendaftaran::create($request->all());

    //     return redirect()->route('kabupaten-kota.index')->with('success', 'Kabupaten Kota created successfully.');
    //     // return view('front-office.verifikasi-pendaftaran.detail', compact('pendaftaran'));
    // }
    public function updateVerifikasi(Request $request, $id)
    {
        // Ambil data dari request
        $files = $request->input('nama_file');
        $valid = $request->input('validasi');
        $catatan_umum = $request->input('catatan_umum');
        $proses_terakhir = $request->input('proses_terakhir');

        // Ambil data yang terkait
        $pendaftaran = requestPendaftaran::findOrFail($id);
        $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
        $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
        $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();

        $userId = Auth::id();

        if ($proses_terakhir === 'Ditolak') {
            // Update current record as rejected
            $pendaftaran->update([
                'verification_status' => 'rejected',
                'verified_by' => $userId,
                'verified_at' => now(),
                'proses_terakhir' => 'Ditolak',
                'alasan_penolakan' => $request->input('alasan_penolakan')
            ]);
        } else {
        // Update current verification status
        $pendaftaran->update([
            'verification_status' => 'verified',
            'verified_by' => $userId,
                'verified_at' => now(),
                'proses_terakhir' => 'Terverifikasi'
        ]);

        // Check if both Kasi and Back Office have verified
        $backOfficeVerified = requestPendaftaran::where('pengajuan_id', $pemohon->pengajuan_id)
            ->where('role', 'Back Office')
            ->where('verification_status', 'verified')
            ->exists();

            // If both have verified, create a new record for permit printing
            if ($backOfficeVerified) {
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
            }
        }

        // Ulangi nilai catatan_umum jika hanya ada satu elemen
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

        return redirect()->route('verifikasi-kasi.index')->with('success', 'Data berhasil diperbarui!');
    }


    // public function updatePendaftaran(Request $request, $id)
    // {
    //     // $request->validate([
    //     //     'kode' => 'required|string|max:255|unique:kabupaten_kotas,kode,' . $id,
    //     //     'nama' => 'required|string|max:255',
    //     //     'singkatan' => 'required|string|max:255',
    //     // ]);

    //     $pendaftaran = requestPendaftaran::findOrFail($id);
    //     $pendaftaran->update($request->all());

    //     return redirect()->route('verifikasi-pendaftaran.index')->with('success', 'Kabupaten Kota updated successfully.');
    // }
}
