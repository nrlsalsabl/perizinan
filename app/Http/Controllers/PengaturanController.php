<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisLayanan;
use App\Models\DaftarPerizinan;
use App\Models\JenisIzin;
use App\Models\JenisPersyaratan;
use App\Models\Workflow;
use App\Models\TemplateIzin;
use App\Models\Template;
use App\Models\TemplateResi;
use App\Models\InformasiPerizinan;
use App\Models\SettingPortal;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PengaturanController extends Controller
{
    public function daftarPerizinan()
    {
        $daftarPerizinan = DaftarPerizinan::all();
        return view('pengaturan.daftar-perizinan', compact('daftarPerizinan'));
    }

    public function jenisLayanan(Request $request)
    {
        $search = $request->input('search');
        $jenisLayanan = JenisLayanan::query()
            ->where('kode_jenis_layanan', 'LIKE', "%{$search}%")
            ->orWhere('nama_jenis_layanan', 'LIKE', "%{$search}%")
            ->orWhere('alias', 'LIKE', "%{$search}%")
            ->paginate(10);
        return view('pengaturan.jenis-layanan', compact('jenisLayanan'));
    }

    public function createJenisLayanan()
    {
        return view('jenis-layanan.create');
    }

    public function storeJenisLayanan(Request $request)
    {
        $request->validate([
            'kode_jenis_layanan' => 'required|string',
            'nama_jenis_layanan' => 'required|string',
            'alias' => 'required|string',

        ]);

        JenisLayanan::create($request->all());

        return redirect()->route('jenis-layanan.index')->with('success', 'Data perizinan created successfully.');
    }
    public function editJenisLayanan($id)
    {
        $jenisLayanan = JenisLayanan::findOrFail($id);
        return view('jenis-layanan.edit', compact('jenisLayanan'));
    }

    public function updateJenisLayanan(Request $request, $id)
    {
        // $daftarperizinan = DaftarPerizinan::findOrFail($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'kode_jenis_layanan' => 'required|string',
            'nama_jenis_layanan' => 'required|string',
            'alias' => 'required|string',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $jenislayanan = JenisLayanan::find($id);
                $jenislayanan->kode_jenis_layanan = $request->kode_jenis_layanan;
                $jenislayanan->nama_jenis_layanan = $request->nama_jenis_layanan;
                $jenislayanan->alias = $request->alias;

                // $jenislayanan->updated_by = auth()->user()->name;
                $jenislayanan->save();
                DB::commit();
                return redirect()->route('jenis-layanan.index')->with([
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

    public function destroyJenisLayanan($id)
    {
        $jenisLayanan = JenisLayanan::findOrFail($id);
        $jenisLayanan->delete();

        return redirect()->route('jenis-layanan.index')->with('success', 'Jenis Layanan berhasil dihapus.');
    }

    public function jenisLayananIzin(Request $request)
    {
        $jenisIzin = JenisIzin::all();
        $selectedJenisIzin = $request->input('jenis_izin');
        $jenisLayanan = collect(); // default to empty collection

        if ($selectedJenisIzin) {
            // Get all jenis layanan since there's no direct relationship yet
            $jenisLayanan = JenisLayanan::all();
        }

        return view('pengaturan.jenis-layanan-izin', compact('jenisIzin', 'jenisLayanan', 'selectedJenisIzin'));
    }

    public function jenisPersyaratan(Request $request)
    {
        $search = $request->input('search');

        $jenisPersyaratan = JenisPersyaratan::query()
            ->where('nama_persyaratan', 'LIKE', "%{$search}%")
            ->orWhere('nama_nomor', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('pengaturan.jenis-persyaratan', compact('jenisPersyaratan'));
    }

    public function workflow()
    {
        $workflows = Workflow::all();
        $tasks = Task::all(); // Fetch tasks based on the workflow, if needed

        return view('pengaturan.workflow', compact('workflows', 'tasks'));
    }

    public function createWorkflow()
    {
        return view('workflow.create');
    }

    public function createTask()
    {
        return view('task.create');
    }

    public function storeWorkflow(Request $request)
    {
        $request->validate([
            'nama_alur' => 'required|string',

        ]);

        Workflow::create($request->all());

        return redirect()->route('workflow.index')->with('success', 'Data perizinan created successfully.');
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'taskname' => 'required|string',
            'status' => 'required|string',

        ]);

        Task::create($request->all());

        return redirect()->route('task.index')->with('success', 'Data perizinan created successfully.');
    }

    public function editWorkflow($id)
    {
        $workflow = Workflow::findOrFail($id);
        return view('workflow.edit', compact('workflow'));
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        return view('task.edit', compact('task'));
    }

    public function updateWorkflow(Request $request, $id)
    {
        // $daftarperizinan = DaftarPerizinan::findOrFail($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'nama_alur' => 'required|string',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $workflow = Workflow::find($id);
                $workflow->nama_alur = $request->nama_alur;

                // $jenislayanan->updated_by = auth()->user()->name;
                $workflow->save();
                DB::commit();
                return redirect()->route('workflow.index')->with([
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

    public function updateTask(Request $request, $id)
    {
        // $daftarperizinan = DaftarPerizinan::findOrFail($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'taskname' => 'required|string',
            'status' => 'required|string',
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {
                $task = Task::find($id);
                $task->taskname = $request->taskname;
                $task->status = $request->status;

                // $jenislayanan->updated_by = auth()->user()->name;
                $task->save();
                DB::commit();
                return redirect()->route('task.index')->with([
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

    public function templateIzin(Request $request)
    {
        $jenisIzins = JenisIzin::all(); // Fetch all Jenis Izin
        $jenisLayanan = JenisLayanan::all();
        $templateIzins = collect();
        $selectedJenisIzin = $request->input('jenis_izin');

        if ($selectedJenisIzin) {
            $templateIzins = TemplateIzin::where('jenis_izin_id', $selectedJenisIzin)
                ->orderBy('updated_at', 'desc') // Urutkan berdasarkan kolom updated_at secara descending (terbaru di atas)
                // ->take(1) // Ambil hanya satu data sebagai koleksi
                ->get();

            // dd($templateIzins);
        }

        // Dummy list of variables for now
        $variables = [
            (object)['caption' => 'NIK Pemohon', 'normal_variable' => 'nik_pemohon', 'uppercase_variable' => 'NIK_PEMOHON'],
            (object)['caption' => 'Nama Pemohon', 'normal_variable' => 'nama_pemohon', 'uppercase_variable' => 'NAMA_PEMOHON'],
            (object)['caption' => 'Alamat Pemohon', 'normal_variable' => 'alamat_pemohon', 'uppercase_variable' => 'ALAMAT_PEMOHON'],
            (object)['caption' => 'Telepon Pemohon', 'normal_variable' => 'telepon_pemohon', 'uppercase_variable' => 'TELEPON_PEMOHON'],
            // Add more variables as needed
        ];

        return view('pengaturan.template-izin', compact('jenisIzins', 'templateIzins', 'selectedJenisIzin', 'variables', 'jenisLayanan'));
    }


    public function templateResi(Request $request)
    {
        $templateResis = TemplateResi::all();
        return view('pengaturan.template-resi', compact('templateResis'));
    }

    public function storeTemplateResi(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'file_doc' => 'required|mimes:doc,docx|max:10240',
        ]);

        $path = $request->file('file_doc')->store('template_resi');

        TemplateResi::create([
            'keterangan' => $request->keterangan,
            'file_doc' => $path,
        ]);

        return redirect()->route('template-resi.index')->with('success', 'Template Resi uploaded successfully');
    }

    public function destroyTemplateResi($id)
    {
        $templateResi = TemplateResi::findOrFail($id);
        $templateResi->delete();

        return redirect()->route('template-resi.index')->with('success', 'Template Resi deleted successfully');
    }

    public function informasiPerizinan(Request $request)
    {
        $search = $request->input('search');

        $informasiPerizinan = InformasiPerizinan::query()
            ->where('jenis_izin', 'LIKE', "%{$search}%")
            ->orWhere('informasi_izin', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('pengaturan.informasi-perizinan', compact('informasiPerizinan'));
    }

    public function createInformasiPerizinan()
    {
        return view('pengaturan.create-informasi-perizinan');
    }

    public function storeInformasiPerizinan(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required|string|max:255',
            'informasi_izin' => 'required|string',
        ]);

        InformasiPerizinan::create($request->all());

        return redirect()->route('informasi-perizinan.index')->with('success', 'Informasi perizinan created successfully.');
    }

    public function editInformasiPerizinan($id)
    {
        $informasiPerizinan = InformasiPerizinan::findOrFail($id);
        return view('pengaturan.edit-informasi-perizinan', compact('informasiPerizinan'));
    }

    public function updateInformasiPerizinan(Request $request, $id)
    {
        $request->validate([
            'jenis_izin' => 'required|string|max:255',
            'informasi_izin' => 'required|string',
        ]);

        $informasiPerizinan = InformasiPerizinan::findOrFail($id);
        $informasiPerizinan->update($request->all());

        return redirect()->route('informasi-perizinan.index')->with('success', 'Informasi perizinan updated successfully.');
    }

    public function destroyInformasiPerizinan($id)
    {
        $informasiPerizinan = InformasiPerizinan::findOrFail($id);
        $informasiPerizinan->delete();

        return redirect()->route('informasi-perizinan.index')->with('success', 'Informasi perizinan deleted successfully.');
    }

    public function settingPortal()
    {
        $settingPortals = SettingPortal::all();
        return view('pengaturan.setting-portal', compact('settingPortals'));
    }

    public function storeSettingPortal(Request $request)
    {
        $request->validate([
            'nama_file' => 'required|string|max:255',
            'file' => 'required|mimes:jpg,jpeg,png',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/setting_portal', $filename);

        SettingPortal::create([
            'nama_file' => $request->nama_file,
            'file_path' => $path,
            'status' => 'active',
        ]);

        return redirect()->route('setting-portal.index')->with('success', 'Image uploaded successfully.');
    }

    public function destroySettingPortal($id)
    {
        $settingPortal = SettingPortal::findOrFail($id);
        if (file_exists(public_path($settingPortal->file_path))) {
            unlink(public_path($settingPortal->file_path));
        }
        $settingPortal->delete();

        return redirect()->route('setting-portal.index')->with('success', 'Image deleted successfully.');
    }

    public function createJenisPersyaratan()
    {
        return view('pengaturan.create-jenis-persyaratan');
    }

    public function storeJenisPersyaratan(Request $request)
    {
        $request->validate([
            'nama_persyaratan' => 'required|string|max:255',
            'nama_nomor' => 'required|string|max:255',
        ]);

        JenisPersyaratan::create($request->all());

        return redirect()->route('jenis-persyaratan.index')->with('success', 'Jenis persyaratan created successfully.');
    }

    public function editJenisPersyaratan($id)
    {
        $persyaratan = JenisPersyaratan::findOrFail($id);
        return view('pengaturan.edit-jenis-persyaratan', compact('persyaratan'));
    }

    public function updateJenisPersyaratan(Request $request, $id)
    {
        $request->validate([
            'nama_persyaratan' => 'required|string|max:255',
            'nama_nomor' => 'required|string|max:255',
        ]);

        $persyaratan = JenisPersyaratan::findOrFail($id);
        $persyaratan->update($request->all());

        return redirect()->route('jenis-persyaratan.index')->with('success', 'Jenis persyaratan updated successfully.');
    }

    public function destroyJenisPersyaratan($id)
    {
        $persyaratan = JenisPersyaratan::findOrFail($id);
        $persyaratan->delete();

        return redirect()->route('jenis-persyaratan.index')->with('success', 'Jenis persyaratan deleted successfully.');
    }

    public function getTemplatesByIzin($id)
    {
        // Fetch templates based on the selected jenis izin
        $templates = Template::where('jenis_izin_id', $id)->get();

        // Return the templates as JSON
        return response()->json(['templates' => $templates]);
    }

    public function uploadTemplate($jenisIzinId)
    {
        // Fetch the selected jenis izin and its templates
        $jenisIzin = JenisIzin::findOrFail($jenisIzinId);
        $templates = Template::where('jenis_izin_id', $jenisIzinId)->get();

        return view('pengaturan.upload-template', compact('jenisIzin', 'templates'));
    }

    public function uploadTemplateFile(Request $request, $jenisIzinId)
    {
        $request->validate([
            'keterangan_file' => 'required|string',
            'file' => 'required|mimes:doc,docx',
        ]);

        $template = new Template();
        $template->jenis_izin_id = $jenisIzinId;
        $template->nama_layanan = $request->input('keterangan_file');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/templates'), $filename);
            $template->template_surat = $filename;
        }

        $template->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function deleteTemplate($id, $type = null)
    {
        try {
            $template = TemplateIzin::findOrFail($id);
            
            if ($type) {
                // Delete specific type (surat or teknis)
                if ($type === 'surat') {
                    if ($template->template_surat) {
                        $filePath = storage_path('app/public/' . $template->template_surat);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $template->template_surat = null;
                    }
                } else {
                    if ($template->template_teknis) {
                        $filePath = storage_path('app/public/' . $template->template_teknis);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $template->template_teknis = null;
                    }
                }
            } else {
                // Delete both templates
                if ($template->template_surat) {
                    $filePath = storage_path('app/public/' . $template->template_surat);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                if ($template->template_teknis) {
                    $filePath = storage_path('app/public/' . $template->template_teknis);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                $template->delete();
                return redirect()->route('template-izin.index')->with('success', 'Template berhasil dihapus.');
            }
            
            $template->save();
            return redirect()->back()->with('success', 'Template berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus template: ' . $e->getMessage());
        }
    }

    public function uploadTemplateIzin(Request $request, $selectedJenisIzin)
    {
        // Validasi input
        $request->validate([
            'template_surat' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
            'template_teknis' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
            'nama_layanan' => 'required|string|max:255',
        ]);

        // Inisialisasi variabel untuk file paths
        $templateSuratPath = null;
        $templateTeknisPath = null;

        // Proses upload file template_surat
        if ($request->hasFile('template_surat')) {
            $file = $request->file('template_surat');
            $filename = time() . '_surat_' . $file->getClientOriginalName();
            $templateSuratPath = $file->storeAs('templates/izin', $filename, 'public');
        }

        // Proses upload file template_teknis
        if ($request->hasFile('template_teknis')) {
            $file = $request->file('template_teknis');
            $filename = time() . '_teknis_' . $file->getClientOriginalName();
            $templateTeknisPath = $file->storeAs('templates/teknis', $filename, 'public');
        }

        // Cek apakah data dengan nama_layanan dan jenis_izin_id sudah ada
        $existingTemplate = TemplateIzin::where('nama_layanan', $request->nama_layanan)
            ->where('jenis_izin_id', $selectedJenisIzin)
            ->first();

        if ($existingTemplate) {
            // Update data jika sudah ada
            $existingTemplate->update([
                'template_surat' => $templateSuratPath ?? $existingTemplate->template_surat,
                'template_teknis' => $templateTeknisPath ?? $existingTemplate->template_teknis,
            ]);
        } else {
            // Buat data baru jika belum ada
            TemplateIzin::create([
                'nama_layanan' => $request->nama_layanan,
                'template_surat' => $templateSuratPath,
                'template_teknis' => $templateTeknisPath,
                'jenis_izin_id' => $selectedJenisIzin,
            ]);
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('template-izin.index', ['jenis_izin' => $selectedJenisIzin])
            ->with('success', 'Template berhasil diunggah!');
    }

    public function uploadTemplateTeknis(Request $request, $id)
    {
        $request->validate([
            'template_teknis' => 'required|mimes:doc,docx,pdf|max:2048',
        ]);

        $templateIzin = TemplateIzin::find($id);

        if ($request->hasFile('template_teknis')) {
            $file = $request->file('template_teknis');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('templates/teknis', $filename, 'public');

            $templateIzin->template_teknis = $path;
            $templateIzin->save();
        }

        return redirect()->route('template-izin.index', ['jenis_izin' => $templateIzin->jenis_izin_id]);
    }

    public function previewTemplate($id, $type)
    {
        try {
            $template = TemplateIzin::findOrFail($id);
            $filePath = $type === 'surat' ? $template->template_surat : $template->template_teknis;
            
            if (!$filePath) {
                return redirect()->back()->with('error', 'Template tidak ditemukan.');
            }

            $fullPath = storage_path('app/public/' . $filePath);
            
            if (!file_exists($fullPath)) {
                return redirect()->back()->with('error', 'File template tidak ditemukan.');
            }

            return response()->file($fullPath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat preview template: ' . $e->getMessage());
        }
    }

    public function manageDaftarPerizinan($id)
    {
        $perizinan = \App\Models\DaftarPerizinan::findOrFail($id);
        // Add your logic here, or just return a view for now
        return view('pengaturan.manage-daftar-perizinan', compact('perizinan'));
    }

    public function updateJenisLayananIzin(Request $request)
    {
        // Validate the request
        $request->validate([
            'layanan_ids' => 'required|array',
            'layanan_ids.*' => 'exists:jenis_layanans,id',
        ]);

        // Here you would typically update the relationship between jenis izin and jenis layanan
        // For now, we'll just return a success message
        
        return redirect()->back()->with('success', 'Jenis layanan berhasil diperbarui untuk jenis izin ini.');
    }
}
