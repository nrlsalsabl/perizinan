<?php

namespace App\Http\Controllers;

use App\Models\DaftarPerizinan;
use App\Models\JenisIzin;
use App\Helpers\PerizinanGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DaftarPerizinanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $daftarPerizinan = DaftarPerizinan::query()
            ->where('kode', 'LIKE', "%{$search}%")
            ->orWhere('nama_jenis_perizinan', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('pengaturan.daftar-perizinan', compact('daftarPerizinan'));
    }

    public function create()
    {
        $jenisIzins = JenisIzin::orderBy('nama_jenis_izin')->get();
        return view('daftar-perizinan.create', compact('jenisIzins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_perizinan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Get the jenis izin name from the selected ID
            $jenisIzin = JenisIzin::findOrFail($request->nama_jenis_perizinan);
            
            // Generate all fields automatically
            $data = [
                'nama_jenis_perizinan' => $jenisIzin->nama_jenis_izin,
                'kode' => PerizinanGenerator::generateKode($jenisIzin->nama_jenis_izin),
                'format_no_izin' => PerizinanGenerator::generateFormatNoIzin($jenisIzin->nama_jenis_izin),
                'masa_berlaku' => PerizinanGenerator::generateMasaBerlaku($jenisIzin->nama_jenis_izin),
                'sop' => PerizinanGenerator::generateSOP($jenisIzin->nama_jenis_izin),
                'dinas_badan' => PerizinanGenerator::generateDinasBadan($jenisIzin->nama_jenis_izin),
                'retribusi' => 'Ya',
                'po' => 'Ya',
                'bu' => 'Ya',
                'status' => 'aktif',
                'online' => '1'
            ];

            // Create DaftarPerizinan record
            $daftarPerizinan = DaftarPerizinan::create($data);

            DB::commit();
            return redirect()->route('daftar-perizinan.index')->with('success', 'Data perizinan created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $daftarperizinan = DaftarPerizinan::findOrFail($id);
        $jenisIzins = JenisIzin::orderBy('nama_jenis_izin')->get();
        return view('daftar-perizinan.edit', compact('daftarperizinan', 'jenisIzins'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_jenis_perizinan' => 'required|string',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $daftarperizinan = DaftarPerizinan::find($id);
                $oldNamaJenis = $daftarperizinan->nama_jenis_perizinan;
                
                // Get the jenis izin name from the selected ID
                $jenisIzin = JenisIzin::findOrFail($request->nama_jenis_perizinan);
                
                // Generate all fields automatically
                $daftarperizinan->nama_jenis_perizinan = $jenisIzin->nama_jenis_izin;
                $daftarperizinan->kode = PerizinanGenerator::generateKode($jenisIzin->nama_jenis_izin);
                $daftarperizinan->format_no_izin = PerizinanGenerator::generateFormatNoIzin($jenisIzin->nama_jenis_izin);
                $daftarperizinan->masa_berlaku = PerizinanGenerator::generateMasaBerlaku($jenisIzin->nama_jenis_izin);
                $daftarperizinan->sop = PerizinanGenerator::generateSOP($jenisIzin->nama_jenis_izin);
                $daftarperizinan->dinas_badan = PerizinanGenerator::generateDinasBadan($jenisIzin->nama_jenis_izin);
                $daftarperizinan->save();

                DB::commit();
                return redirect()->route('daftar-perizinan.index')->with([
                    'status' => 'success',
                    'message' => 'Data updated!'
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getMessage());
                return redirect()->back()->with([
                    'status' => 'failed',
                    'message' => $th->getMessage()
                ]);
            }
        }
        return redirect()->back()->withErrors($validate->getMessageBag())->withInput();
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $daftarPerizinan = DaftarPerizinan::findOrFail($id);
            $namaJenis = $daftarPerizinan->nama_jenis_perizinan;
            
            // Delete from DaftarPerizinan
            $daftarPerizinan->delete();
            
            DB::commit();
            return redirect()->route('daftar-perizinan.index')->with('success', 'Data perizinan deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }
}
