<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KabupatenKota;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\DataHariLibur;
use App\Models\BentukPerusahaan;
use App\Models\KelolaDataKadis;
use App\Models\DataKBLI;
use App\Models\TabelReferensi;
use App\Models\Kategori;
use App\Models\JenisIzin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MasterDataController extends Controller
{
    public function provinsi(Request $request)
    {
        $search = $request->input('search');
        $provinsi = Provinsi::query()
            ->where('kode', 'LIKE', "%{$search}%")
            ->orWhere('nama', 'LIKE', "%{$search}%")
            ->orWhere('singkatan', 'LIKE', "%{$search}%")
            ->paginate(10); // Assuming you want pagination

        return view('master-data.provinsi', compact('provinsi'));
    }


    public function createProvinsi()
    {
        return view('master-data.create-provinsi');
    }

    public function storeProvinsi(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
            'singkatan' => 'required|string',

        ]);

        Provinsi::create($request->all());

        return redirect()->route('provinsi.index')->with('success', 'Data perizinan created successfully.');
    }
    public function editProvinsi($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return view('master-data.edit-provinsi', compact('provinsi'));
    }

    public function updateProvinsi(Request $request, $id)
    {
        // $daftarperizinan = DaftarPerizinan::findOrFail($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'kode' => 'required|string',
            'nama' => 'required|string',
            'singkatan' => 'required|string',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $provinsi = Provinsi::find($id);
                $provinsi->kode = $request->kode;
                $provinsi->nama = $request->nama;
                $provinsi->singkatan = $request->singkatan;

                // $provinsi->updated_by = auth()->user()->name;
                $provinsi->save();
                DB::commit();
                return redirect()->route('provinsi.index')->with([
                    'status' => 'success',
                    'message' => 'Data updated!'
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getMessage());
                $data = [
                    'status' => 'failed',
                    'message' => $th->getMessage()
                ];
                return view('error')->with($data);
            }
        }
        return redirect()->back()->withErrors($validate->getMessageBag())->withInput();

        // Update data role
        // $daftarperizinan->update($request->all());

        // return redirect()->route('daftar-perizinan.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyProvinsi($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->delete();

        return redirect()->route('provinsi.index')->with('success', 'Jenis Layanan berhasil dihapus.');
    }

    public function kabupatenKota()
    {
        $kabupatenKota = KabupatenKota::all();
        return view('master-data.kabupaten-kota', compact('kabupatenKota'));
    }

    public function createKabupatenKota()
    {
        return view('master-data.create-kabupaten-kota');
    }

    public function storeKabupatenKota(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
            'singkatan' => 'required|string',
        ]);

        $provinsi = Provinsi::find($request->singkatan);
        $request->merge(['singkatan' => $provinsi->nama]);

        KabupatenKota::create($request->all());

        return redirect()->route('kabupaten-kota.index')->with('success', 'Kabupaten Kota created successfully.');
    }

    public function editKabupatenKota($id)
    {
        $kabupatenKota = KabupatenKota::findOrFail($id);
        return view('master-data.edit-kabupaten-kota', compact('kabupatenKota'));
    }

    public function updateKabupatenKota(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:kabupaten_kotas,kode,' . $id,
            'nama' => 'required|string|max:255',
            'singkatan' => 'required|string|max:255',
        ]);

        $kabupatenKota = KabupatenKota::findOrFail($id);
        $kabupatenKota->update($request->all());

        return redirect()->route('kabupaten-kota.index')->with('success', 'Kabupaten Kota updated successfully.');
    }

    public function destroyKabupatenKota($id)
    {
        $kabupatenKota = KabupatenKota::findOrFail($id);
        $kabupatenKota->delete();

        return redirect()->route('kabupaten-kota.index')->with('success', 'Kabupaten Kota deleted successfully.');
    }

    public function get_subprovinsi(Request $request)
    {
        $subprovinsi = Provinsi::select('id', DB::raw("concat(kode,' - ', nama) as nama"))
            ->get();

        $results = [
            'status' => 'success',
            'data' => $subprovinsi,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }


    public function get_kode(Request $request)
    {
        $singkatan = $request->singkatan;
        $provinsi = Provinsi::find($singkatan);
        $kodeProvinsi = $provinsi->kode;

        $lastKode = KabupatenKota::where('kode', 'like', $kodeProvinsi . '%')
            ->orderBy('kode', 'desc')
            ->first();

        if ($lastKode) {
            $lastKode = $lastKode->kode;
            $nextKode = (int) $lastKode + 1;
        } else {
            $nextKode = (int) $kodeProvinsi . '01';
        }

        $results = [
            'status' => 'success',
            'nextkode' => $nextKode,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }


    public function kecamatan(Request $request)
    {
        $search = $request->input('search');

        $kecamatans = Kecamatan::query()
            ->with(['kabupatenKota', 'provinsi'])
            ->where('kode', 'LIKE', "%{$search}%")
            ->orWhere('nama', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('master-data.kecamatan', compact('kecamatans'));
    }

    public function createKecamatan()
    {
        return view('master-data.create-kecamatan');
    }

    public function storeKecamatan(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',

        ]);
        $provinsi = Provinsi::find($request->provinsi);
        $kabupaten = KabupatenKota::find($request->kabupaten_kota);
        $request->merge(['provinsi' => $provinsi->nama]);
        $request->merge(['kabupaten_kota' => $kabupaten->nama]);

        Kecamatan::create($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Data perizinan created successfully.');
    }
    public function editKecamatan($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $provinsi = Provinsi::all(); // Ambil semua data provinsi

        // Cek apakah request adalah AJAX
        if (request()->ajax()) {
            return response()->json([
                'kecamatan' => $kecamatan,
                'provinsi' => $provinsi,
            ]);
        }

        // Jika bukan AJAX, kembalikan tampilan view
        return view('master-data.edit-kecamatan', compact('kecamatan', 'provinsi'));
    }

    public function updateKecamatan(Request $request, $id)
    {
        // $daftarperizinan = DaftarPerizinan::findOrFail($id);

        // Validasi input
        $request->validate([
            'kode' => 'required|string|max:255|unique:kecamatans,kode,' . $id,
            'nama' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',
        ]);

        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Kabupaten Kota updated successfully.');
    }

    public function destroyKecamatan($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')->with('success', 'Jenis Layanan berhasil dihapus.');
    }

    public function get_subprovinsi2(Request $request)
    {
        $subprovinsi = Provinsi::select('id', DB::raw("concat(kode,' - ', nama) as nama"))
            ->get();

        $results = [
            'status' => 'success',
            'data' => $subprovinsi,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }

    public function get_subkabupaten(Request $request)
    {
        $provinsi = Provinsi::find($request->provinsi);
        $subkabupaten = KabupatenKota::where('singkatan', $provinsi->kode)
            ->select('id', DB::raw("concat(kode,' - ', nama) as nama"))
            ->get();

        $results = [
            'status' => 'success',
            'data' => $subkabupaten,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }

    public function get_subkecamatan(Request $request)
    {
        $kabupatenKota = KabupatenKota::find($request->kabupaten_kota);
        $subKecamatan = Kecamatan::where('kabupaten_kota', $kabupatenKota->kode)
            ->select('id', DB::raw("concat(kode,' - ', nama) as nama"))
            ->get();

        $results = [
            'status' => 'success',
            'data' => $subKecamatan,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }


    public function get_kodekabupaten(Request $request)
    {
        $kabupaten_kota = $request->kabupaten_kota;
        // Cek apakah kode yang sama sudah ada di tabel Kecamatan
        $existingKode = KabupatenKota::where('kode', 'like', $kabupaten_kota . '%')->exists();
        if (!$existingKode) {
            // Jika ada kode yang sama, hentikan proses
            return response()->json([
                'status' => 'error',
                // 'nextkode' => $existingKode->kode,
                'message' => 'Kode sudah ada, tidak perlu melanjutkan proses.',
            ]);
        }
        $kabupaten = KabupatenKota::find($kabupaten_kota);
        $kodeKabupaten = $kabupaten->kode;

        $lastKode = Kecamatan::where('kode', 'like', $kodeKabupaten . '%')
            ->orderBy('kode', 'desc')
            ->first();

        if ($lastKode) {
            $lastKode = $lastKode->kode;
            $nextKode = (int) $lastKode + 1;
        } else {
            $nextKode = (int) $kodeKabupaten . '01';
        }

        $results = [
            'status' => 'success',
            'nextkode' => $nextKode,
            'message' => 'Data saved!',
        ];

        return response()->json($results);
    }

    public function dataHariLibur(Request $request)
    {
        $search = $request->input('search');
        $dataHariLibur = DataHariLibur::query()
            ->where('tanggal_libur', 'LIKE', "%{$search}%")
            ->orWhere('deskripsi', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('master-data.data-hari-libur', compact('dataHariLibur'));
    }

    public function createHariLibur()
    {
        return view('master-data.create-hari-libur');
    }

    public function storeHariLibur(Request $request)
    {
        $request->validate([
            'tanggal_libur' => 'required|date',
            'deskripsi' => 'required|string|max:255',
        ]);

        DataHariLibur::create($request->all());

        return redirect()->route('data-hari-libur.index')->with('success', 'Hari Libur created successfully.');
    }

    public function editHariLibur($id)
    {
        $hariLibur = DataHariLibur::findOrFail($id);
        return view('master-data.edit-hari-libur', compact('hariLibur'));
    }

    public function updateHariLibur(Request $request, $id)
    {
        $request->validate([
            'tanggal_libur' => 'required|date',
            'deskripsi' => 'required|string|max:255',
        ]);

        $hariLibur = DataHariLibur::findOrFail($id);
        $hariLibur->update($request->all());

        return redirect()->route('data-hari-libur.index')->with('success', 'Hari Libur updated successfully.');
    }

    public function destroyHariLibur($id)
    {
        $hariLibur = DataHariLibur::findOrFail($id);
        $hariLibur->delete();

        return redirect()->route('data-hari-libur.index')->with('success', 'Hari Libur deleted successfully.');
    }

    public function bentukPerusahaan(Request $request)
    {
        $search = $request->input('search');
        $bentukPerusahaan = BentukPerusahaan::query()
            ->where('bentuk_perusahaan', 'LIKE', "%{$search}%")
            ->orWhere('singkatan', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('master-data.bentuk-perusahaan', compact('bentukPerusahaan'));
    }

    public function createBentukPerusahaan()
    {
        return view('master-data.create-bentuk-perusahaan');
    }

    public function storeBentukPerusahaan(Request $request)
    {
        $request->validate([
            'bentuk_perusahaan' => 'required|string',
            'singkatan' => 'required|string',

        ]);

        BentukPerusahaan::create($request->all());

        return redirect()->route('bentuk-perusahaan.index')->with('success', 'Data perizinan created successfully.');
    }
    public function editBentukPerusahaan($id)
    {
        $bentukPerusahaan = BentukPerusahaan::findOrFail($id);
        return view('master-data.edit-bentuk-perusahaan', compact('bentukPerusahaan'));
    }

    public function updateBentukPerusahaan(Request $request, $id)
    {
        // $daftarperizinan = DaftarPerizinan::findOrFail($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'bentuk_perusahaan' => 'required|string',
            'singkatan' => 'required|string',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $bentukPerusahaan = BentukPerusahaan::find($id);
                $bentukPerusahaan->bentuk_perusahaan = $request->bentuk_perusahaan;
                $bentukPerusahaan->singkatan = $request->singkatan;

                // $provinsi->updated_by = auth()->user()->name;
                $bentukPerusahaan->save();
                DB::commit();
                return redirect()->route('bentuk-perusahaan.index')->with([
                    'status' => 'success',
                    'message' => 'Data updated!'
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getMessage());
                $data = [
                    'status' => 'failed',
                    'message' => $th->getMessage()
                ];
                return view('error')->with($data);
            }
        }
        return redirect()->back()->withErrors($validate->getMessageBag())->withInput();

        // Update data role
        // $daftarperizinan->update($request->all());

        // return redirect()->route('daftar-perizinan.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyBentukPerusahaan($id)
    {
        $bentukPerusahaan = BentukPerusahaan::findOrFail($id);
        $bentukPerusahaan->delete();

        return redirect()->route('bentuk-perusahaan.index')->with('success', 'Jenis Layanan berhasil dihapus.');
    }

    public function kelolaDataKadis(Request $request)
    {
        $search = $request->input('search');
        $kelolaDataKadis = KelolaDataKadis::query()
            ->where('nip', 'LIKE', "%{$search}%")
            ->orWhere('nama', 'LIKE', "%{$search}%")
            ->orWhere('pangkat', 'LIKE', "%{$search}%")
            ->orWhere('periode', 'LIKE', "%{$search}%")
            ->orWhere('status', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('master-data.kelola-data-kadis', compact('kelolaDataKadis'));
    }

    public function createKelolaDataKadis()
    {
        $jenisIzins = JenisIzin::all();
        return view('master-data.create-kelola-data-kadis', compact('jenisIzins'));
    }

    public function storeKelolaDataKadis(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'nama' => 'required|string',
            'pangkat' => 'required|string',
            'periode' => 'required|string',
            'status' => 'required|string',
            'ttd' => 'nullable',
        ]);

        $data = $request->all();

        KelolaDataKadis::create($data);

        return redirect()->route('kelola-data-kadis.index')->with('success', 'Data Kadis created successfully.');
    }

    public function editKelolaDataKadis($id)
    {
        $kadis = KelolaDataKadis::findOrFail($id);
        return view('master-data.edit-kelola-data-kadis', compact('kadis'));
    }

    public function updateKelolaDataKadis(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nip' => 'required|string',
            'nama' => 'required|string',
            'pangkat' => 'required|string',
            'periode' => 'required|string',
            'status' => 'required|string',
            'ttd' => 'nullable',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $kadis = KelolaDataKadis::find($id);
                $kadis->nip = $request->nip;
                $kadis->nama = $request->nama;
                $kadis->pangkat = $request->pangkat;
                $kadis->periode = $request->periode;
                $kadis->status = $request->status;
                $kadis->ttd = $request->ttd;

                // $provinsi->updated_by = auth()->user()->name;
                $kadis->save();
                DB::commit();
                return redirect()->route('kelola-data-kadis.index')->with([
                    'status' => 'success',
                    'message' => 'Data updated!'
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getMessage());
                $data = [
                    'status' => 'failed',
                    'message' => $th->getMessage()
                ];
                return view('error')->with($data);
            }
        }
        return redirect()->back()->withErrors($validate->getMessageBag())->withInput();
    }

    public function destroyKelolaDataKadis($id)
    {
        $kadis = KelolaDataKadis::findOrFail($id);
        // if (file_exists(storage_path('app/' . $kadis->ttd))) {
        //     unlink(storage_path('app/' . $kadis->ttd));
        // }
        $kadis->delete();

        return redirect()->route('kelola-data-kadis.index')->with('success', 'Data Kadis deleted successfully.');
    }

    public function dataKBLI(Request $request)
    {
        $search = $request->input('search');
        $kbliData = DataKBLI::query()
            ->where('kode_kbli', 'LIKE', "%{$search}%")
            ->orWhere('nama_kbli', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('master-data.data-kbli', compact('kbliData'));
    }

    public function createDataKBLI()
    {
        return view('master-data.create-data-kbli');
    }

    public function storeDataKBLI(Request $request)
    {
        $request->validate([
            'kode_kbli' => 'required|string|max:255',
            'nama_kbli' => 'required|string|max:255',
        ]);

        DataKBLI::create($request->all());

        return redirect()->route('data-kbli.index')->with('success', 'Data KBLI created successfully.');
    }

    public function editDataKBLI($id)
    {
        $kbli = DataKBLI::findOrFail($id);
        return view('master-data.edit-data-kbli', compact('kbli'));
    }

    public function updateDataKBLI(Request $request, $id)
    {
        $request->validate([
            'kode_kbli' => 'required|string|max:255',
            'nama_kbli' => 'required|string|max:255',
        ]);

        $kbli = DataKBLI::findOrFail($id);
        $kbli->update($request->all());

        return redirect()->route('data-kbli.index')->with('success', 'Data KBLI updated successfully.');
    }

    public function destroyDataKBLI($id)
    {
        $kbli = DataKBLI::findOrFail($id);
        $kbli->delete();

        return redirect()->route('data-kbli.index')->with('success', 'Data KBLI deleted successfully.');
    }

    public function tabelReferensi(Request $request)
    {
        $tabelReferensis = TabelReferensi::all();
        return view('master-data.tabel-referensi', compact('tabelReferensis'));
    }

    public function storeTabelReferensi(Request $request)
    {
        $request->validate([
            'nama_tabel' => 'required|string|max:255',
        ]);

        TabelReferensi::create($request->all());

        return redirect()->route('tabel-referensi.index')->with('success', 'Tabel Referensi created successfully.');
    }

    public function destroyTabelReferensi($id)
    {
        $tabelReferensi = TabelReferensi::findOrFail($id);
        $tabelReferensi->delete();

        return redirect()->route('tabel-referensi.index')->with('success', 'Tabel Referensi deleted successfully.');
    }

    public function kategori($id)
    {
        $tabelReferensi = TabelReferensi::findOrFail($id);
        $kategoris = Kategori::where('tabel_referensi_id', $id)->get();
        return view('master-data.kategori', compact('tabelReferensi', 'kategoris'));
    }

    public function createKategori($id)
    {
        $tabelReferensi = TabelReferensi::findOrFail($id);
        return view('master-data.create-kategori', compact('tabelReferensi'));
    }

    public function storeKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'tabel_referensi_id' => $id,
        ]);

        return redirect()->route('kategori.index', $id)->with('success', 'Kategori created successfully.');
    }

    public function editKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('master-data.edit-kategori', compact('kategori'));
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index', $kategori->tabel_referensi_id)->with('success', 'Kategori updated successfully.');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index', $kategori->tabel_referensi_id)->with('success', 'Kategori deleted successfully.');
    }
}
