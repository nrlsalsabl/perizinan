<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisIzin;
use App\Exports\RekapitulasiIzinExport; // Create this export class
use App\Models\RekapitulasiIzin;
use App\Models\DataArsip;
use App\Models\JenisLayanan;
use Illuminate\Support\Facades\DB;
use App\Models\ProsesIzin;
use App\Models\Petugas;
use App\Models\IzinTerbit;
use App\Models\PermohonanIzin;
use App\Models\RequestPendaftaran;

class MonitoringController extends Controller
{

    public function rekapitulasiIzin(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $jenisIzin = $request->input('jenis_izin');

        // Ambil data terakhir per resi
        $subQuery = DB::table('request_perizinan as rp1')
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('resi');

        $query = DB::table('request_perizinan')
            ->joinSub($subQuery, 'latest', function ($join) {
                $join->on('request_perizinan.id', '=', 'latest.id');
            })
            ->leftJoin('data_pemohons', 'request_perizinan.user_id', '=', 'data_pemohons.id')
            ->select(
                'request_perizinan.resi',
                'request_perizinan.nama_pemohon as nama_pemohon',
                'request_perizinan.jenis_izin',
                'request_perizinan.created_at',
                'request_perizinan.updated_at'
            );

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('request_perizinan.created_at', [$tanggalAwal, $tanggalAkhir]);
        }

        if ($jenisIzin) {
            $query->where('request_perizinan.jenis_izin', $jenisIzin);
        }

        $dataIzin = $query->orderBy('request_perizinan.created_at', 'desc')->get();

        // Untuk dropdown filter
        $jenisIzins = DB::table('request_perizinan')
            ->select('jenis_izin')
            ->distinct()
            ->pluck('jenis_izin');

        return view('monitoring.rekapitulasi-izin', compact('dataIzin', 'jenisIzins'));
    }

    
    public function monitoringPerizinan(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $jenisIzin = $request->input('jenis_izin');

        // Logika untuk mendapatkan data monitoring perizinan
        $query = RekapitulasiIzin::with('jenisIzin');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        }

        if ($jenisIzin) {
            $query->where('jenis_izin_id', $jenisIzin); // Pastikan ini sesuai dengan nama kolom di tabel
        }

        $dataIzin = $query->get();
        $jenisIzins = JenisIzin::all();

        return view('monitoring.monitoring-perizinan', compact('dataIzin', 'jenisIzins'));
    }


    public function jumlahIzin()
    {
        return view('monitoring.jumlah-izin');
    }










 public function dataArsip(Request $request)
{
    $query = DB::table('request_perizinan')
        ->join('data_pemohons', 'data_pemohons.pengajuan_id', '=', 'request_perizinan.pengajuan_id')
        ->leftJoin('data_perusahaans', 'data_perusahaans.pemohon_id', '=', 'data_pemohons.id')
        ->select(
            'data_pemohons.id as account',
            'data_pemohons.nik as nik_npwp',
            'data_pemohons.name as nama_pemohon',
            'data_pemohons.alamat',
            'data_perusahaans.nama_perusahaan',
            'data_perusahaans.alamat as alamat_perusahaan'
        );

    // Filter opsional
    if ($request->filled('nik_npwp')) {
        $query->where('data_pemohons.nik', 'like', '%' . $request->nik_npwp . '%');
    }

    if ($request->filled('nama_pemohon')) {
        $query->where('data_pemohons.name', 'like', '%' . $request->nama_pemohon . '%');
    }

    if ($request->filled('nama_perusahaan')) {
        $query->where('data_perusahaans.nama_perusahaan', 'like', '%' . $request->nama_perusahaan . '%');
    }

    $dataArsip = $query
        ->groupBy(
            'data_pemohons.id',
            'data_pemohons.nik',
            'data_pemohons.name',
            'data_pemohons.alamat',
            'data_perusahaans.nama_perusahaan',
            'data_perusahaans.alamat'
        )
        ->paginate(10);

    return view('monitoring.data-arsip', compact('dataArsip'));
}











    public function monitoringIzin(Request $request)
    {
        $query = RekapitulasiIzin::with('jenisIzin'); // Menyertakan relasi jenisIzin

        // Filter berdasarkan input dari form
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pengajuan', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('jenis_izin_id')) {
            $query->where('jenis_izin_id', $request->jenis_izin_id);
        }

        if ($request->filled('search')) {
            $query->where('nama_pemohon', 'like', '%' . $request->search . '%');
        }

        // Paginasi dan hasil query
        $dataIzin = $query->paginate($request->input('display', 10)); // Default 10 records

        $jenisIzins = JenisIzin::all(); // Mendapatkan semua jenis izin untuk dropdown

        return view('monitoring.monitoring-izin', compact('dataIzin', 'jenisIzins'));
    }


    public function izinTerbit(Request $request)
    {
        $query = IzinTerbit::with('jenisIzin'); // Menyertakan relasi dengan jenis izin

        // Filter berdasarkan input dari form
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_terbit', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('jenis_izin_id')) {
            $query->where('jenis_izin_id', $request->jenis_izin_id);
        }

        $dataIzin = $query->paginate(10); // Menggunakan paginasi 10 data per halaman
        $jenisIzins = JenisIzin::all(); // Mendapatkan semua jenis izin untuk dropdown

        return view('monitoring.izin-terbit', compact('dataIzin', 'jenisIzins'));
    }

    public function viewIzin($id)
    {
        $izin = IzinTerbit::findOrFail($id);
        return view('monitoring.view-izin', compact('izin'));
    }

    public function releasePermohonan(Request $request)
    {
        $query = RequestPendaftaran::query();

        // Filter berdasarkan input dari form
        if ($request->filled('jenis_izin_id')) {
            $jenisIzin = JenisIzin::find($request->jenis_izin_id);
            if ($jenisIzin) {
                $query->where('jenis_izin', $jenisIzin->nama_jenis_izin);
            }
        }

        if ($request->filled('jenis_layanan')) {
            $jenisLayanan = JenisLayanan::find($request->jenis_layanan);
            if ($jenisLayanan) {
                $query->where('jenis_permohonan', $jenisLayanan->nama_layanan);
            }
        }

        if ($request->filled('search')) {
            $query->where('nama_pemohon', 'like', '%' . $request->search . '%');
        }

        $dataPermohonan = $query->paginate(10); // Paginasi

        $jenisIzins = JenisIzin::all();
        $jenisLayanans = JenisLayanan::all();

        return view('monitoring.release-permohonan', compact('dataPermohonan', 'jenisIzins', 'jenisLayanans'));
    }

    public function updateReleasePermohonan(Request $request, $id)
    {
        $permohonan = RequestPendaftaran::findOrFail($id);

        // Create new record with updated process
        RequestPendaftaran::create([
            'pengajuan_id' => $permohonan->pengajuan_id,
            'user_id' => $permohonan->user_id,
            'resi' => $permohonan->resi,
            'nama_pemohon' => $permohonan->nama_pemohon,
            'jenis_izin' => $permohonan->jenis_izin,
            'jenis_permohonan' => $permohonan->jenis_permohonan,
            'proses_terakhir' => $request->proses,
            'role' => $permohonan->role,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('release-permohonan.index')->with('success', 'Permohonan berhasil dikembalikan ke proses.');
    }

    public function monitoringDashboard(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $jenisIzin = $request->input('jenis_izin');

        // Mulai query dasar
        $query = RequestPendaftaran::query();

        // Filter berdasarkan rentang tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        }

        // Filter berdasarkan jenis izin
        if ($jenisIzin) {
            $query->where('jenis_izin', $jenisIzin); // Sesuaikan kolom ini dengan nama di database
        }

        // Ambil data terakhir berdasarkan pengajuan_id
        $dataIzin = $query->orderBy('pengajuan_id', 'desc')
            ->Take(1)
            ->get();

        // Ambil semua jenis izin untuk dropdown
        $jenisIzins = JenisIzin::all();

        // Ambil data terbaru per pengajuan_id
        $dataTerbaru = RequestPendaftaran::selectRaw('MAX(id) as id_terbaru')
            ->groupBy('pengajuan_id');

        // Hitung jumlah data dengan proses_terakhir = "Pendaftaran"
        $jumlahPendaftaran = RequestPendaftaran::whereIn('id', $dataTerbaru)
            ->where('proses_terakhir', 'Pendaftaran')
            ->count();

        $jumlahKasiVerif = RequestPendaftaran::whereIn('id', $dataTerbaru)
            ->where('proses_terakhir', 'Proses Kasi')
            ->count();

        $jumlahBackVerif = RequestPendaftaran::whereIn('id', $dataTerbaru)
            ->where('proses_terakhir', 'Proses BackOffice')
            ->count();

        $jumlahCetak = RequestPendaftaran::whereIn('id', $dataTerbaru)
            ->where('proses_terakhir', 'Cetak Izin')
            ->count();

        $jumlahDitolak = RequestPendaftaran::whereIn('id', $dataTerbaru)
            ->where('proses_terakhir', 'Ditolak')
            ->count();

        // Return ke view
        return view('monitoring.dashboard-monitoring', compact('dataIzin', 'jenisIzins', 'jumlahPendaftaran', 'jumlahKasiVerif', 'jumlahBackVerif', 'jumlahCetak', 'jumlahDitolak'));
    }

    public function monitoringPerizinanFO()
    {
        $logs = DB::table('request_perizinan')->get();

        // Group by resi
        $grouped = $logs->groupBy('resi');

        $data = $grouped->map(function ($items, $resi) {
            $first = $items->first(); // Ambil info umum dari baris pertama

            return (object) [
                'resi' => $resi,
                'nama_pemohon' => $first->nama_pemohon,
                'jenis_izin' => $first->jenis_izin,
                'fo_status' => optional($items->firstWhere('role', 'Front Office'))->proses_terakhir,
                'kasi_status' => optional($items->firstWhere('role', 'Kasi'))->proses_terakhir,
                'bo_status' => optional($items->firstWhere('role', 'Back Office'))->proses_terakhir,
                'cetak_status' => optional($items->where('role', 'Back Office')->where('proses_terakhir', 'Cetak Izin')->last())->proses_terakhir,
            ];
        })->values();

        return view('monitoring.dashboard-perizinanfo', [
            'data' => $data
        ]);
    }
}
