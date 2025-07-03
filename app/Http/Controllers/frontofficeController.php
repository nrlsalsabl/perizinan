<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\dataDetail;
use App\Models\dataPemohon;
use App\Models\dataPerusahaan;
use App\Models\lokasiIzin;
use App\Models\requestPendaftaran;
use App\Models\TemplateIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class frontofficeController extends Controller
{
    // [Previous methods remain unchanged...]

    public function indexPendaftaran()
    {
        $pengajuanIds = requestPendaftaran::select('pengajuan_id')
            ->groupBy('pengajuan_id')
            ->havingRaw('SUM(CASE WHEN proses_terakhir = "Ditolak" THEN 1 ELSE 0 END) = 0')
            ->havingRaw('SUM(CASE WHEN proses_terakhir = "Ditolak" THEN 1 ELSE 0 END) = 0')
            ->pluck('pengajuan_id');

        $pendaftaran = requestPendaftaran::where('proses_terakhir', 'Pendaftaran')
            ->whereIn('pengajuan_id', $pengajuanIds)
            ->where('role', 'Front Office')
            ->where('verification_status', 'pending')
            ->get();

        $perusahaan = dataPerusahaan::all();
        return view('front-office.verifikasi-pendaftaran.index', compact('pendaftaran', 'perusahaan'));
    }

    public function detailPendaftaran($id)
    {
        $pendaftaran = requestPendaftaran::findOrFail($id);
        $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
        $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->firstOrFail();
        $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->firstOrFail();
        $lampiran = dataDetail::where('lokasi_id', $lokasi->id)->firstOrFail();
        
        return view('front-office.verifikasi-pendaftaran.detail', compact('pendaftaran', 'pemohon', 'perusahaan', 'lokasi', 'lampiran'));
    }

public function updatePendaftaran(Request $request, $id)
{
    $request->validate([
        'proses_terakhir' => 'required|in:Proses Kasi,Ditolak',
        'alasan_penolakan' => 'required_if:proses_terakhir,Ditolak',
        'resi' => 'required',
        'name' => 'required',
        'jenis_izin' => 'required',
        'jenis_permohonan' => 'required'
    ]);

    $pendaftaran = requestPendaftaran::findOrFail($id);
    $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->firstOrFail();
    $userId = Auth::id();

    if ($request->input('proses_terakhir') === 'Proses Kasi') {
        // Front Office menverifikasi, lanjut ke Kasi
        $pendaftaran->update([
            'verification_status' => 'verified',
            'proses_terakhir' => 'Terverifikasi',
            'verified_by' => $userId,
            'verified_at' => now()
        ]);

        requestPendaftaran::create([
            'resi' => $request->input('resi'),
            'nama_pemohon' => $request->input('name'),
            'pengajuan_id' => $pemohon->pengajuan_id,
            'user_id' => $userId,
            'jenis_izin' => $request->input('jenis_izin'),
            'jenis_permohonan' => $request->input('jenis_permohonan'),
            'proses_terakhir' => 'Proses Kasi',
            'role' => 'Kasi',
            'verification_status' => 'pending',
            'verified_at' => now(),
            'verified_by' => $userId
        ]);
    } else {
        // Front Office menolak
        requestPendaftaran::create([
            'resi' => $request->input('resi'),
            'nama_pemohon' => $request->input('name'),
            'pengajuan_id' => $pemohon->pengajuan_id,
            'user_id' => $userId,
            'jenis_izin' => $request->input('jenis_izin'),
            'jenis_permohonan' => $request->input('jenis_permohonan'),
            'proses_terakhir' => 'Ditolak',
            'role' => 'Front Office',
            'verification_status' => 'rejected',
            'catatan' => $request->input('alasan_penolakan'),
            'verified_at' => now(),
            'verified_by' => $userId
        ]);
    }

    return redirect()->route('verifikasi-pendaftaran.index')
        ->with('success', 'Status pendaftaran berhasil diperbarui!');
}



    public function printSertifikat($id)
    {
        try {
            Log::info('printSertifikat called', ['id' => $id]);
            $pendaftaran = requestPendaftaran::find($id);
            if (!$pendaftaran) throw new \Exception('Pendaftaran not found');
            Log::info('Step: found pendaftaran', ['pendaftaran' => $pendaftaran]);

            $pemohon = dataPemohon::where('pengajuan_id', $pendaftaran->pengajuan_id)->first();
            if (!$pemohon) throw new \Exception('Pemohon not found');
            Log::info('Step: found pemohon', ['pemohon' => $pemohon]);

            $perusahaan = dataPerusahaan::where('pemohon_id', $pemohon->id)->first();
            if (!$perusahaan) throw new \Exception('Perusahaan not found');
            Log::info('Step: found perusahaan', ['perusahaan' => $perusahaan]);

            $lokasi = lokasiIzin::where('perusahaan_id', $perusahaan->id)->first();
            if (!$lokasi) throw new \Exception('Lokasi not found');
            Log::info('Step: found lokasi', ['lokasi' => $lokasi]);

            // Log the value being searched for
            $searchValue = trim($pendaftaran->jenis_izin);
            Log::info('Searching DaftarPerizinan for', ['nama_jenis_perizinan' => $searchValue]);

            // Try exact match first
            $daftarPerizinan = \App\Models\DaftarPerizinan::where('nama_jenis_perizinan', $searchValue)->first();

            // If not found, try case-insensitive and trimmed match
            if (!$daftarPerizinan) {
                $daftarPerizinan = \App\Models\DaftarPerizinan::whereRaw('LOWER(TRIM(nama_jenis_perizinan)) = ?', [strtolower($searchValue)])->first();
            }

            // Log all possible values for debugging
            if (!$daftarPerizinan) {
                $all = \App\Models\DaftarPerizinan::pluck('nama_jenis_perizinan')->toArray();
                Log::error('DaftarPerizinan not found. Available values:', $all);
                throw new \Exception('DaftarPerizinan not found for "' . $searchValue . '". Available: ' . implode(', ', $all));
            }

            Log::info('Step: found daftarPerizinan', ['daftarPerizinan' => $daftarPerizinan]);
            Log::info('jenis_izin value', ['jenis_izin' => $pendaftaran->jenis_izin]);
            
            // Get the request parameters
            $template = request('template', 'template_surat');
            $ttdType = request('ttd', 'digital');
            
            Log::info("Template: {$template}, TTD Type: {$ttdType}");
            
            // Get active Kadis data
            $kadis = \App\Models\KelolaDataKadis::where('status', 'Aktif')->first();
            $ttdPath = null;
            $kadisNama = $kadis ? $kadis->nama : '';
            $kadisNip = $kadis ? $kadis->nip : '';
            
            // Set TTD path only if digital signature is requested and available
            if ($ttdType === 'digital' && $kadis && $kadis->ttd) {
                $ttdPath = asset('storage/Aktif/TTD.png');
            }
            
            // Generate permit number using the format
            try {
                $permitNumber = \App\Helpers\PermitNumberGenerator::generate($pendaftaran->jenis_izin_id);
            } catch (\Exception $e) {
                Log::error('Error generating permit number: ' . $e->getMessage());
                // Fallback to a temporary number if generation fails
                $permitNumber = 'TEMP-' . date('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);
            }
            
            // Prepare data for the view
            $data = [
                'no_izin' => $permitNumber,
                'nama_pemohon' => $pemohon->name,
                'nik' => $pemohon->nik,
                'alamat' => $pemohon->alamat,
                'nama_perusahaan' => $perusahaan->nama_perusahaan,
                'nib' => $perusahaan->nib,
                'npwp' => $perusahaan->npwp,
                'alamat_perusahaan' => $perusahaan->alamat,
                'lokasi_izin' => $lokasi->jalan . ' No. ' . $lokasi->nomor . ' RT ' . $lokasi->rt . ' RW ' . $lokasi->rw,
                'tanggal_terbit' => now()->format('d F Y'),
                'kadis_nama' => $kadisNama,
                'kadis_nip' => $kadisNip,
                'ttd_path' => $ttdPath,
                'jenis_izin' => $pendaftaran->jenis_izin ?? '',
                'jenis_permohonan' => $pendaftaran->jenis_permohonan ?? '',
                'resi' => $pendaftaran->resi ?? '',
                'masa_berlaku' => $daftarPerizinan->masa_berlaku ?? '5 Tahun',
                'status' => $pendaftaran->status ?? 'Aktif',
            ];
            
            Log::info('Rendering view with data: ' . json_encode($data));
            
            // Return the appropriate view based on template parameter
            if ($template === 'template_surat') {
                return view('templates.sertifikat', compact('data', 'ttdType'));
            } else {
                throw new \Exception('Template tidak ditemukan');
            }
            
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
    }

public function getStats()
{
    $jumlahPendaftaran = requestPendaftaran::where('proses_terakhir', 'Pendaftaran')->count();
    $jumlahKasiVerif = requestPendaftaran::where('role', 'Kasi')
        ->where('verification_status', 'verified')->count();
    $jumlahBackVerif = requestPendaftaran::where('role', 'Back Office')
        ->where('verification_status', 'verified')->count();
    $jumlahCetak = requestPendaftaran::where('proses_terakhir', 'Cetak Izin')->count();
    $jumlahDitolak = requestPendaftaran::where('proses_terakhir', 'Ditolak')->count();

    return response()->json([
        'total' => $jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak,
        'pendaftaran' => $jumlahPendaftaran,
        'kasiVerif' => $jumlahKasiVerif,
        'backVerif' => $jumlahBackVerif,
        'cetak' => $jumlahCetak,
        'ditolak' => $jumlahDitolak,
        'selesai' => $jumlahCetak,
        'dalamProses' => $jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif
    ]);
}


}
