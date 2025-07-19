<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\requestPendaftaran;
use App\Models\JenisIzin;

class LaporanController extends Controller
{
    // public function queryBuilder(Request $request)
    // {
    //     // Inisialisasi query
    //     $query = DB::table('request_perizinan')
    //         ->join('jenis_izins', 'request_perizinan.jenis_izin', '=', 'jenis_izins.id')
    //         ->select('request_perizinan.*', 'jenis_izins.nama_jenis_izin');

    //     // Filter berdasarkan tahun atau bulan
    //     if ($request->input('time_range') == 'tahun') {
    //         $query->whereYear('request_perizinan.created_at', $request->input('tahun'));
    //     }

    //     // Filter berdasarkan status izin
    //     if ($request->filled('status_izin')) {
    //         $query->where('request_perizinan.status', $request->input('status_izin'));
    //     }

    //     // Filter berdasarkan jenis izin
    //     if ($request->filled('jenis_izin')) {
    //         $query->where('request_perizinan.jenis_izin', $request->input('jenis_izin'));
    //     }

    //     // Eksekusi query dan mendapatkan hasil
    //     $results = $query->get();

    //     // Mendapatkan daftar jenis izin untuk dropdown
    //     $jenisIzins = DB::table('jenis_izins')->get();

    //     return view('laporan.query-builder', compact('results', 'jenisIzins'));
    // }
    // public function queryBuilder(Request $request)
    // {
    //     // Query dasar: Ambil data terbaru per pengajuan_id berdasarkan created_at
    //     $query = DB::table('request_perizinan as rp')
    //         ->join('jenis_izins as ji', 'rp.jenis_izin', '=', 'ji.id')
    //         ->select('rp.*', 'ji.nama_jenis_izin')
    //         ->whereRaw('rp.created_at = (SELECT MAX(created_at) FROM request_perizinan WHERE pengajuan_id = rp.pengajuan_id)');

    //     // Filter berdasarkan status izin (proses terakhir)
    //     if ($request->filled('status_izin') && $request->status_izin !== 'semua') {
    //         if ($request->status_izin === 'Proses') {
    //             $query->where('rp.proses_terakhir', 'like', '%Proses%');
    //         } elseif ($request->status_izin === 'Cetak Izin') {
    //             $query->where('rp.proses_terakhir', 'like', '%Cetak Izin%');
    //         } elseif ($request->status_izin === 'Ditolak') {
    //             $query->where('rp.proses_terakhir', 'like', '%Ditolak%');
    //         }
    //     }

    //     // Filter berdasarkan jenis permohonan
    //     if ($request->filled('jenis_permohonan') && $request->jenis_permohonan !== 'semua') {
    //         $query->where('rp.jenis_permohonan', $request->jenis_permohonan);
    //     }

    //     // Filter berdasarkan jenis izin
    //     if ($request->filled('jenis_izin')) {
    //         $query->where('rp.jenis_izin', $request->jenis_izin);
    //     }

    //     // Eksekusi query
    //     $results = $query->get();

    //     // Mendapatkan daftar jenis izin untuk dropdown
    //     $jenisIzins = DB::table('jenis_izins')->get();

    //     return view('laporan.query-builder', compact('results', 'jenisIzins'));
    // }
    public function queryBuilder(Request $request)
    {
        $status = $request->input('status_izin');
        $permohonan = $request->input('jenis_permohonan');
        $izin = $request->input('jenis_izin');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Mulai query dasar
        $query = requestPendaftaran::query();

        // Filter berdasarkan jenis izin
        if ($izin && $izin !== '') {
            $query->where('jenis_izin', $izin);
        }

        // Filter berdasarkan jenis permohonan
        if ($permohonan && $permohonan !== 'semua') {
            $query->where('jenis_permohonan', $permohonan);
        }

        // Filter berdasarkan status
        if ($status && $status !== 'semua') {
            $query->where('proses_terakhir', 'LIKE', "%{$status}%");
        }

        // Filter berdasarkan rentang tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        }

        // Ambil data terakhir berdasarkan pengajuan_id
        $results = $query->orderBy('created_at', 'desc')
            ->get();

        // Ambil semua jenis izin untuk dropdown
        $jenisIzins = JenisIzin::all();

        return view('laporan.query-builder', compact('results', 'jenisIzins'));
    }

    public function exportExcel(Request $request)
    {
        // TODO: Implement Excel export
        return response()->json(['message' => 'Excel export functionality will be implemented']);
    }

    public function exportPDF(Request $request)
    {
        // TODO: Implement PDF export
        return response()->json(['message' => 'PDF export functionality will be implemented']);
    }

    public function viewDetails($id)
    {
        $detail = requestPendaftaran::findOrFail($id);
        
        // Get the latest verification status for each role
        $frontOfficeStatus = requestPendaftaran::where('pengajuan_id', $detail->pengajuan_id)
            ->where('role', 'Front Office')
            ->latest()
            ->first();

        $kasiStatus = requestPendaftaran::where('pengajuan_id', $detail->pengajuan_id)
            ->where('role', 'Kasi')
            ->latest()
            ->first();

        $backOfficeStatus = requestPendaftaran::where('pengajuan_id', $detail->pengajuan_id)
            ->where('role', 'Back Office')
            ->where('verification_status', 'verified')
            ->latest()
            ->first();
        

        $data = [
            'id' => $detail->id,
            'created_at' => $detail->created_at,
            'proses_terakhir' => $detail->proses_terakhir,
            'nomor_izin' => $detail->nomor_izin,
            'tanggal_terbit' => $detail->tanggal_terbit,
            
            // Front Office verification
            'verifikasi_front_office' => $frontOfficeStatus ? $frontOfficeStatus->verification_status === 'verified' : false,
            'tanggal_verifikasi_front_office' => $frontOfficeStatus ? $frontOfficeStatus->verified_at : null,
            'petugas_front_office' => $frontOfficeStatus ? $frontOfficeStatus->verified_by : null,
            
            // Kasi verification
            'verifikasi_kasi' => $kasiStatus ? $kasiStatus->verification_status === 'verified' : false,
            'tanggal_verifikasi_kasi' => $kasiStatus ? $kasiStatus->verified_at : null,
            'petugas_kasi' => $kasiStatus ? $kasiStatus->verified_by : null,
            
            // Back Office verification
            'verifikasi_back_office' => $backOfficeStatus ? $backOfficeStatus->verification_status === 'verified' : false,
            'tanggal_verifikasi_back_office' => $backOfficeStatus ? $backOfficeStatus->verified_at : null,
            'petugas_back_office' => $backOfficeStatus ? $backOfficeStatus->verified_by : null,
        ];

        return response()->json($data);
    }

    // public function rekapitulasiIzin(Request $request)
    // {
    //     $tanggalAwal = $request->input('tanggal_awal');
    //     $tanggalAkhir = $request->input('tanggal_akhir');
    //     $jenisIzin = $request->input('jenis_izin');

    //     // Mulai query dasar
    //     $query = requestPendaftaran::query();

    //     // Filter berdasarkan rentang tanggal
    //     if ($tanggalAwal && $tanggalAkhir) {
    //         $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
    //     }

    //     // Filter berdasarkan jenis izin
    //     if ($jenisIzin) {
    //         $query->where('jenis_izin', $jenisIzin); // Sesuaikan kolom ini dengan nama di database
    //     }

    //     // Ambil data terakhir berdasarkan pengajuan_id
    //     $dataIzin = $query->orderBy('pengajuan_id', 'desc')
    //         ->Take(1)
    //         ->get();

    //     // Ambil semua jenis izin untuk dropdown
    //     $jenisIzins = JenisIzin::all();

    //     // Return ke view
    //     return view('monitoring.rekapitulasi-izin', compact('dataIzin', 'jenisIzins'));
    // }
}
