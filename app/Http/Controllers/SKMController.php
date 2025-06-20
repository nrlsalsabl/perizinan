<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\JenisIzin;
use App\Models\Pertanyaan;
use App\Models\Jawaban;

class SKMController extends Controller
{
    public function hasilSurvey(Request $request)
    {
        // Query dasar
        $query = Survey::with('jenisIzin');

        // Filter berdasarkan tanggal awal dan tanggal akhir
        if ($request->filled('tanggal_awal')) {
            $query->where('tanggal_survey', '>=', $request->input('tanggal_awal'));
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal_survey', '<=', $request->input('tanggal_akhir'));
        }

        // Filter berdasarkan jenis izin
        if ($request->filled('jenis_izin')) {
            $query->where('jenis_izin_id', $request->input('jenis_izin'));
        }

        // Dapatkan hasil query
        $surveys = $query->get();

        // Mendapatkan data jenis izin untuk dropdown
        $jenisIzins = JenisIzin::all();

        return view('skm.hasil-survey', compact('surveys', 'jenisIzins'));
    }

    public function daftarPertanyaan(Request $request)
    {
        // Query dasar untuk mendapatkan pertanyaan
        $query = Pertanyaan::with('jawaban');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->input('search') . '%');
        }

        // Mendapatkan data pertanyaan dengan paginasi
        $pertanyaan = $query->paginate(10);

        return view('skm.daftar-pertanyaan', compact('pertanyaan'));
    }

    public function tambahPertanyaan()
    {
        // Tampilan untuk form tambah pertanyaan
        return view('skm.tambah-pertanyaan');
    }

    public function storePertanyaan(Request $request)
    {
        // Validasi
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban.*.pilihan_jawaban' => 'required|string|max:255',
            'jawaban.*.bobot_nilai' => 'required|integer|min:1|max:5',
        ]);

        // Menyimpan pertanyaan
        $pertanyaan = Pertanyaan::create([
            'pertanyaan' => $request->pertanyaan,
            'status' => true, // Default status aktif
        ]);

        // Menyimpan jawaban
        foreach ($request->jawaban as $j) {
            Jawaban::create([
                'pertanyaan_id' => $pertanyaan->id,
                'pilihan_jawaban' => $j['pilihan_jawaban'],
                'bobot_nilai' => $j['bobot_nilai'],
            ]);
        }

        return redirect()->route('skm.daftar-pertanyaan')->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function editPertanyaan($id)
    {
        $pertanyaan = Pertanyaan::with('jawaban')->findOrFail($id);
        return view('skm.edit-pertanyaan', compact('pertanyaan'));
    }

    public function updatePertanyaan(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban.*.pilihan_jawaban' => 'required|string|max:255',
            'jawaban.*.bobot_nilai' => 'required|integer|min:1|max:5',
        ]);

        // Update pertanyaan
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update(['pertanyaan' => $request->pertanyaan]);

        // Update jawaban
        foreach ($request->jawaban as $key => $j) {
            $jawaban = Jawaban::find($key);
            $jawaban->update([
                'pilihan_jawaban' => $j['pilihan_jawaban'],
                'bobot_nilai' => $j['bobot_nilai'],
            ]);
        }

        return redirect()->route('skm.daftar-pertanyaan')->with('success', 'Pertanyaan berhasil diperbarui');
    }

    public function deletePertanyaan($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();
        return redirect()->route('skm.daftar-pertanyaan')->with('success', 'Pertanyaan berhasil dihapus');
    }
}
