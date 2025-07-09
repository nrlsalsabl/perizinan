<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AccountPemohonController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DaftarPerizinanController;
use App\Http\Controllers\TemplateResiController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SKMController;
use App\Http\Controllers\PengajuanPermohonanController;
use App\Http\Controllers\DataPemohonController;
use App\Http\Controllers\DataPerusahaanController;
use App\Http\Controllers\LokasiIzinController;
use App\Http\Controllers\DataDetailController;
use App\Http\Controllers\frontofficeController;
use App\Http\Controllers\frontendController;
use App\Http\Middleware\JabatanMiddleware;
use App\Http\Controllers\kasiController;
use App\Http\Controllers\backofficeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LaporanExportController;
use App\Http\Controllers\VerificationStatusController;
use Illuminate\Support\Facades\Mail;

Route::get('/tes-email', function () {
    Mail::raw('Tes kirim dari Laravel ke email Gmail yang sama', function ($msg) {
        $msg->to('kidosan122@gmail.com'); // Kirim ke diri sendiri
        $msg->subject('Tes Gmail ke Gmail via Brevo');
    });

    return '✅ Email terkirim (cek inbox/spam)';
});


Route::get('/debug-email', function () {
    \Illuminate\Support\Facades\Mail::raw('Tes SMTP Brevo', function ($m) {
        $m->to('alamatgmailkamu@gmail.com')->subject('Tes Kirim dari Laravel Lokal via Brevo');
    });

    return 'Email test dikirim';
});


// Home Route
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::post('/perizinan-online', [AuthController::class, 'login'])->name('login');
Route::get('/perizinan-online', [AuthController::class, 'showLoginForm'])->name('perizinan-online');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Register Route
// Route::get('/register', function () {
//     return view('register');
// })->name('register');
Route::get('/register', [UserController::class, 'registrasiIndex'])->name('registrasi.index');
Route::post('/register', [UserController::class, 'registrasi'])->name('users.registrasi');
Route::get('/master-data/kecamatan/get_subprovinsi2', [MasterDataController::class, 'get_subprovinsi2'])->name('kecamatan.get_subprovinsi2');
Route::get('/master-data/kecamatan/get_kodeprovinsi2', [MasterDataController::class, 'get_kodeprovinsi2'])->name('kecamatan.get_kodeprovinsi2');
Route::get('/master-data/kecamatan/{id}/get_editkecamatan', [MasterDataController::class, 'getEditKecamatan'])->name('kecamatan.get_editkecamatan');
Route::get('/master-data/kecamatan/get_subkabupaten', [MasterDataController::class, 'get_subkabupaten'])->name('kecamatan.get_subkabupaten');
Route::get('/master-data/kecamatan/get_subkecamatan', [MasterDataController::class, 'get_subkecamatan'])->name('kecamatan.get_subkecamatan');
Route::get('/master-data/kecamatan/get_kodekabupaten', [MasterDataController::class, 'get_kodekabupaten'])->name('kecamatan.get_kodekabupaten');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Password Reset Routes
// Route::get('/password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
Route::get('/persyaratan', [PageController::class, 'persyaratan'])->name('persyaratan');

Route::middleware(['auth'])->group(function () {
    // Print Sertifikat route - more specific path
    Route::get('/sertifikat/print/{id}', [frontofficeController::class, 'printSertifikat'])
        ->name('print-sertifikat');

    // Page Routes
    Route::get('/online-single-submission', [PageController::class, 'onlineSingleSubmission'])->name('online-single-submission');
    
    Route::get('/website', [PageController::class, 'website'])->name('website');
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/{id}/edit', [UserController::class, 'registrasiEdit'])->name('edit-user.registrasi');
    Route::put('/dashboard/{id}', [UserController::class, 'registrasiUpdate'])->name('update-user.registrasi');

    // User routes - accessible by both 'user' and 'front end' roles
    Route::middleware(['auth', 'jabatan:user,front end'])->group(function () {
        Route::get('/pengajuan-permohonan/create', [PengajuanPermohonanController::class, 'create'])->name('pengajuan-permohonan.create');
        Route::post('/pengajuan-permohonan', [PengajuanPermohonanController::class, 'store'])->name('pengajuan-permohonan.store');
        Route::get('/pengajuan-permohonan/get_jenisizin', [PengajuanPermohonanController::class, 'get_jenisizin'])->name('pengajuan-permohonan.get_jenisizin');
        Route::get('/monitoring-frontend', [frontendController::class, 'index'])->name('monitoring-frontend.index');
        Route::get('/monitoring-frontend/{id}/show', [frontendController::class, 'show'])->name('monitoring-frontend.show');
    });

    // Admin routes
    Route::middleware(['auth', 'jabatan:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });

    // Front office routes
    Route::middleware(['auth', 'jabatan:front office'])->group(function () {
        Route::get('/verifikasi-pendaftaran', [frontofficeController::class, 'indexPendaftaran'])->name('verifikasi-pendaftaran.index');
        Route::get('/verifikasi-pendaftaran/{id}/detail', [frontofficeController::class, 'detailPendaftaran'])->name('verifikasi-pendaftaran.detail');
        Route::post('/verifikasi-pendaftaran/{id}', [frontofficeController::class, 'updatePendaftaran'])->name('verifikasi-pendaftaran.update');
    });

    // Back office routes
    Route::middleware(['auth', 'jabatan:back office'])->group(function () {
        Route::get('/proses-backoffice', [backofficeController::class, 'indexProses'])->name('proses-backoffice.index');
        Route::get('/proses-backoffice/{id}/detail', [backofficeController::class, 'detailProses'])->name('proses-backoffice.detail');
        Route::post('/proses-backoffice/{id}', [backofficeController::class, 'updateProses'])->name('proses-backoffice.update');
        Route::get('/penyerahan-izin', [backofficeController::class, 'indexPenyerahan'])->name('penyerahan-izin.index');
        Route::get('/penyerahan-izin/{id}/detail', [backofficeController::class, 'detailPenyerahan'])->name('penyerahan-izin.detail');
        Route::post('/penyerahan-izin/{id}', [backofficeController::class, 'updatePenyerahan'])->name('penyerahan-izin.update');
        Route::get('/api/verification-status/{id}', [backofficeController::class, 'getVerificationStatus']);

    });

    // Kasi routes
    Route::middleware(['auth', 'jabatan:kasi'])->group(function () {
        Route::get('/verifikasi-kasi', [kasiController::class, 'indexVerifikasi'])->name('verifikasi-kasi.index');
        Route::get('/verifikasi-kasi/{id}/detail', [kasiController::class, 'detailVerifikasi'])->name('verifikasi-kasi.detail');
        Route::post('/verifikasi-kasi/{id}', [kasiController::class, 'updateVerifikasi'])->name('verifikasi-kasi.update');
        Route::get('/api/verification-status-kasi/{pengajuanId}', [kasiController::class, 'getVerificationStatus'])->name('api.kasi.verification-status');
    });

    Route::post('/save-code', [AuthController::class, 'saveCode'])->name('save.code');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('menus', MenuController::class);

    Route::prefix('pengaturan')->group(function () {
        Route::get('/daftar-perizinan', [PengaturanController::class, 'daftarPerizinan'])->name('daftar-perizinan.index');
        Route::get('/jenis-layanan', [PengaturanController::class, 'jenisLayanan'])->name('jenis-layanan.index');
        Route::get('/jenis-layanan-izin', [PengaturanController::class, 'jenisLayananIzin'])->name('jenis-layanan-izin.index');
        Route::get('/jenis-persyaratan', [PengaturanController::class, 'jenisPersyaratan'])->name('jenis-persyaratan.index');
        Route::get('/workflow', [PengaturanController::class, 'workflow'])->name('workflow.index');
        Route::get('/template-izin', [PengaturanController::class, 'templateIzin'])->name('template-izin.index');
        Route::get('/template-izin/preview/{id}/{type}', [PengaturanController::class, 'previewTemplate'])->name('template-izin.preview');
        Route::delete('/template-izin/delete/{id}/{type}', [PengaturanController::class, 'deleteTemplate'])->name('template-izin.delete');
        Route::get('/template-resi', [PengaturanController::class, 'templateResi'])->name('template-resi.index');
        Route::post('template-resi', [PengaturanController::class, 'storeTemplateResi'])->name('template-resi.store');
        Route::delete('template-resi/{id}', [PengaturanController::class, 'destroyTemplateResi'])->name('template-resi.destroy');
        Route::get('informasi-perizinan', [PengaturanController::class, 'informasiPerizinan'])->name('informasi-perizinan.index');
        Route::get('informasi-perizinan/create', [PengaturanController::class, 'createInformasiPerizinan'])->name('informasi-perizinan.create');
        Route::post('informasi-perizinan', [PengaturanController::class, 'storeInformasiPerizinan'])->name('informasi-perizinan.store');
        Route::get('informasi-perizinan/{id}/edit', [PengaturanController::class, 'editInformasiPerizinan'])->name('informasi-perizinan.edit');
        Route::put('informasi-perizinan/{id}', [PengaturanController::class, 'updateInformasiPerizinan'])->name('informasi-perizinan.update');
        Route::delete('informasi-perizinan/{id}', [PengaturanController::class, 'destroyInformasiPerizinan'])->name('informasi-perizinan.destroy');
        Route::get('/setting-portal', [PengaturanController::class, 'settingPortal'])->name('setting-portal.index');
        Route::post('/setting-portal', [PengaturanController::class, 'storeSettingPortal'])->name('setting-portal.store');
        Route::delete('/setting-portal/{id}', [PengaturanController::class, 'destroySettingPortal'])->name('setting-portal.destroy');
    });

    Route::resource('permissions', PermissionController::class);
    Route::resource('daftar-perizinan', DaftarPerizinanController::class);
    Route::get('/pengaturan/jenis-layanan', [PengaturanController::class, 'jenisLayanan'])->name('jenis-layanan.index');
    Route::get('/pengaturan/jenis-layanan/create', [PengaturanController::class, 'createJenisLayanan'])->name('jenis-layanan.create');
    Route::post('/pengaturan/jenis-layanan', [PengaturanController::class, 'storeJenisLayanan'])->name('jenis-layanan.store');
    Route::get('/pengaturan/jenis-layanan/{id}/edit', [PengaturanController::class, 'editJenisLayanan'])->name('jenis-layanan.edit');
    Route::put('/pengaturan/jenis-layanan/{id}', [PengaturanController::class, 'updateJenisLayanan'])->name('jenis-layanan.update');
    Route::delete('/pengaturan/jenis-layanan/{id}', [PengaturanController::class, 'destroyJenisLayanan'])->name('jenis-layanan.destroy');

    Route::get('/pengaturan/jenis-layanan-izin', [PengaturanController::class, 'jenisLayananIzin'])->name('jenis-layanan-izin.index');
    Route::post('/jenis-layanan-izin/update', [PengaturanController::class, 'updateJenisLayananIzin'])->name('jenis-layanan-izin.update');

    Route::get('/pengaturan/jenis-persyaratan', [PengaturanController::class, 'jenisPersyaratan'])->name('jenis-persyaratan.index');
    Route::get('/pengaturan/jenis-persyaratan/create', [PengaturanController::class, 'createJenisPersyaratan'])->name('jenis-persyaratan.create');
    Route::post('/pengaturan/jenis-persyaratan', [PengaturanController::class, 'storeJenisPersyaratan'])->name('jenis-persyaratan.store');
    Route::get('/pengaturan/jenis-persyaratan/{id}/edit', [PengaturanController::class, 'editJenisPersyaratan'])->name('jenis-persyaratan.edit');
    Route::put('/pengaturan/jenis-persyaratan/{id}', [PengaturanController::class, 'updateJenisPersyaratan'])->name('jenis-persyaratan.update');
    Route::delete('/pengaturan/jenis-persyaratan/{id}', [PengaturanController::class, 'destroyJenisPersyaratan'])->name('jenis-persyaratan.destroy');

    Route::get('/pengaturan/workflow', [PengaturanController::class, 'workflow'])->name('workflow.index');
    Route::get('/pengaturan/workflow/create', [PengaturanController::class, 'createWorkflow'])->name('workflow.create');
    Route::post('/pengaturan/workflow', [PengaturanController::class, 'storeWorkflow'])->name('workflow.store');
    Route::get('/pengaturan/workflow/{id}/edit', [PengaturanController::class, 'editWorkflow'])->name('workflow.edit');
    Route::put('/pengaturan/workflow/{id}', [PengaturanController::class, 'updateWorkflow'])->name('workflow.update');
    Route::delete('/pengaturan/workflow/{id}', [PengaturanController::class, 'destroyWorkflow'])->name('workflow.destroy');

    Route::get('/pengaturan/task/create', [PengaturanController::class, 'createTask'])->name('task.create');
    Route::post('/pengaturan/task', [PengaturanController::class, 'storeTask'])->name('task.store');
    Route::get('/pengaturan/task/{id}/edit', [PengaturanController::class, 'editTask'])->name('task.edit');
    Route::put('/pengaturan/task/{id}', [PengaturanController::class, 'updateTask'])->name('task.update');
    Route::delete('/pengaturan/task/{id}', [PengaturanController::class, 'destroyTask'])->name('task.destroy');

    Route::get('/pengaturan/template-izin', [PengaturanController::class, 'templateIzin'])->name('template-izin.index');
    Route::get('/pengaturan/template-izin/{id}', [PengaturanController::class, 'getTemplatesByIzin']);

    Route::get('/pengaturan/template-izin/{id}', [PengaturanController::class, 'uploadTemplate'])->name('upload.template');
    Route::post('/pengaturan/template-izin/{id}', [PengaturanController::class, 'uploadTemplateFile'])->name('upload.template');
    Route::delete('/pengaturan/template-izin/{id}', [PengaturanController::class, 'deleteTemplate'])->name('delete.template');

    Route::get('/template-izin', [PengaturanController::class, 'templateIzin'])->name('template-izin.index');

    Route::get('/pengaturan/template-izin', [PengaturanController::class, 'templateIzin'])->name('template-izin.index');
    Route::post('/pengaturan/template-izin/upload/{id}', [PengaturanController::class, 'uploadTemplateIzin'])->name('template-izin.upload');
    Route::post('/pengaturan/template-teknis/upload/{id}', [PengaturanController::class, 'uploadTemplateTeknis'])->name('template-teknis.upload');

    Route::resource('template-resi', TemplateResiController::class);
    Route::get('/template-resi', [TemplateResiController::class, 'index'])->name('template-resi.index');
    Route::post('/template-resi', [TemplateResiController::class, 'store'])->name('template-resi.store');
    Route::delete('/template-resi/{id}', [TemplateResiController::class, 'destroy'])->name('template-resi.destroy');

    Route::prefix('master-data')->group(function () {
        Route::get('provinsi', [MasterDataController::class, 'provinsi'])->name('provinsi.index');
        Route::get('kabupaten-kota', [MasterDataController::class, 'kabupatenKota'])->name('kabupaten-kota.index');
        Route::get('kecamatan', [MasterDataController::class, 'kecamatan'])->name('kecamatan.index');
        Route::get('data-hari-libur', [MasterDataController::class, 'dataHariLibur'])->name('data-hari-libur.index');
        Route::get('bentuk-perusahaan', [MasterDataController::class, 'bentukPerusahaan'])->name('bentuk-perusahaan.index');
        Route::get('kelola-data-kadis', [MasterDataController::class, 'kelolaDataKadis'])->name('kelola-data-kadis.index');
        Route::get('data-kbli', [MasterDataController::class, 'dataKBLI'])->name('data-kbli.index');
        Route::get('tabel-referensi', [MasterDataController::class, 'tabelReferensi'])->name('tabel-referensi.index');
    });

    Route::get('/master-data/provinsi', [MasterDataController::class, 'provinsi'])->name('provinsi.index');
    Route::get('/master-data/provinsi/create', [MasterDataController::class, 'createProvinsi'])->name('provinsi.create');
    Route::post('/master-data/provinsi', [MasterDataController::class, 'storeProvinsi'])->name('provinsi.store');
    Route::get('/master-data/provinsi/{id}/edit', [MasterDataController::class, 'editProvinsi'])->name('provinsi.edit');
    Route::put('/master-data/provinsi/{id}', [MasterDataController::class, 'updateProvinsi'])->name('provinsi.update');
    Route::delete('/master-data/provinsi/{id}', [MasterDataController::class, 'destroyProvinsi'])->name('provinsi.destroy');

    Route::get('/master-data/kabupaten-kota', [MasterDataController::class, 'kabupatenKota'])->name('kabupaten-kota.index');
    Route::get('/master-data/kabupaten-kota/create', [MasterDataController::class, 'createKabupatenKota'])->name('kabupaten-kota.create');
    Route::post('/master-data/kabupaten-kota', [MasterDataController::class, 'storeKabupatenKota'])->name('kabupaten-kota.store');
    Route::get('/master-data/kabupaten-kota/{id}/edit', [MasterDataController::class, 'editKabupatenKota'])->name('kabupaten-kota.edit');
    Route::put('/master-data/kabupaten-kota/{id}', [MasterDataController::class, 'updateKabupatenKota'])->name('kabupaten-kota.update');
    Route::delete('/master-data/kabupaten-kota/{id}', [MasterDataController::class, 'destroyKabupatenKota'])->name('kabupaten-kota.destroy');
    Route::get('/master-data/kabupaten-kota/get_subprovinsi', [MasterDataController::class, 'get_subprovinsi'])->name('kabupaten-kota.get_subprovinsi');
    Route::get('/master-data/kabupaten-kota/get_kode', [MasterDataController::class, 'get_kode'])->name('kabupaten-kota.get_kode');

    Route::get('/master-data/kecamatan', [MasterDataController::class, 'kecamatan'])->name('kecamatan.index');
    Route::get('/master-data/kecamatan/create', [MasterDataController::class, 'createKecamatan'])->name('kecamatan.create');
    Route::post('/master-data/kecamatan', [MasterDataController::class, 'storeKecamatan'])->name('kecamatan.store');
    Route::get('/master-data/kecamatan/{id}/edit', [MasterDataController::class, 'editKecamatan'])->name('kecamatan.edit');
    Route::put('/master-data/kecamatan/{id}', [MasterDataController::class, 'updateKecamatan'])->name('kecamatan.update');
    Route::delete('/master-data/kecamatan/{id}', [MasterDataController::class, 'destroyKecamatan'])->name('kecamatan.destroy');
    // Route::get('/master-data/kecamatan/get_subprovinsi2', [MasterDataController::class, 'get_subprovinsi2'])->name('kecamatan.get_subprovinsi2');
    // Route::get('/master-data/kecamatan/get_kodeprovinsi2', [MasterDataController::class, 'get_kodeprovinsi2'])->name('kecamatan.get_kodeprovinsi2');
    // Route::get('/master-data/kecamatan/{id}/get_editkecamatan', [MasterDataController::class, 'getEditKecamatan'])->name('kecamatan.get_editkecamatan');
    // Route::get('/master-data/kecamatan/get_subkabupaten', [MasterDataController::class, 'get_subkabupaten'])->name('kecamatan.get_subkabupaten');
    // Route::get('/master-data/kecamatan/get_subkecamatan', [MasterDataController::class, 'get_subkecamatan'])->name('kecamatan.get_subkecamatan');
    // Route::get('/master-data/kecamatan/get_kodekabupaten', [MasterDataController::class, 'get_kodekabupaten'])->name('kecamatan.get_kodekabupaten');

    Route::get('/data-pemohon/create', [DataPemohonController::class, 'create'])->name('data-pemohon.create');
    Route::post('/data-pemohon', [DataPemohonController::class, 'store'])->name('data-pemohon.store');
    Route::get('/data-pemohon/show', [DataPemohonController::class, 'show'])->name('data-pemohon.show');
    // Route::get('/pengajuan-permohonan/get_jenisizin', [PengajuanPermohonanController::class, 'get_jenisizin'])->name('pengajuan-permohonan.get_jenisizin');

    Route::get('/data-perusahaan/create', [DataPerusahaanController::class, 'create'])->name('data-perusahaan.create');
    Route::post('/data-perusahaan', [DataPerusahaanController::class, 'store'])->name('data-perusahaan.store');
    Route::get('/data-perusahaan/show', [DataPerusahaanController::class, 'show'])->name('data-perusahaan.show');
    Route::get('/data-perusahaan/get_bentukperusahaan', [DataPerusahaanController::class, 'get_bentukperusahaan'])->name('data-perusahaan.get_bentukperusahaan');
    Route::get('/data-perusahaan/get_statusperusahaan', [DataPerusahaanController::class, 'get_statusperusahaan'])->name('data-perusahaan.get_statusperusahaan');

    Route::get('/lokasi-izin/create', [LokasiIzinController::class, 'create'])->name('lokasi-izin.create');
    Route::post('/lokasi-izin', [LokasiIzinController::class, 'store'])->name('lokasi-izin.store');
    Route::get('/lokasi-izin/show', [LokasiIzinController::class, 'show'])->name('lokasi-izin.show');
    // Route::get('/pengajuan-permohonan/get_jenisizin', [PengajuanPermohonanController::class, 'get_jenisizin'])->name('pengajuan-permohonan.get_jenisizin');

    Route::get('/data-lampiran/create', [DataDetailController::class, 'create'])->name('data-lampiran.create');
    Route::post('/data-lampiran', [DataDetailController::class, 'store'])->name('data-lampiran.store');
    Route::get('/data-lampiran/show', [DataDetailController::class, 'show'])->name('data-lampiran.show');
    Route::get('/data-lampiran/detail/{id}', [DataDetailController::class, 'detail'])->name('data-lampiran.detail');
    // Route::get('/pengajuan-permohonan/get_jenisizin', [PengajuanPermohonanController::class, 'get_jenisizin'])->name('pengajuan-permohonan.get_jenisizin');  

    Route::get('data-hari-libur/create', [MasterDataController::class, 'createHariLibur'])->name('data-hari-libur.create');
    Route::post('data-hari-libur', [MasterDataController::class, 'storeHariLibur'])->name('data-hari-libur.store');
    Route::get('data-hari-libur/{id}/edit', [MasterDataController::class, 'editHariLibur'])->name('data-hari-libur.edit');
    Route::put('data-hari-libur/{id}', [MasterDataController::class, 'updateHariLibur'])->name('data-hari-libur.update');
    Route::delete('data-hari-libur/{id}', [MasterDataController::class, 'destroyHariLibur'])->name('data-hari-libur.destroy');

    Route::get('master-data/bentuk-perusahaan', [MasterDataController::class, 'bentukPerusahaan'])->name('bentuk-perusahaan.index');
    Route::get('master-data/bentuk-perusahaan/create', [MasterDataController::class, 'createBentukPerusahaan'])->name('bentuk-perusahaan.create');
    Route::post('master-data/bentuk-perusahaan', [MasterDataController::class, 'storeBentukPerusahaan'])->name('bentuk-perusahaan.store');
    Route::get('master-data/bentuk-perusahaan/{id}/edit', [MasterDataController::class, 'editBentukPerusahaan'])->name('bentuk-perusahaan.edit');
    Route::put('master-data/bentuk-perusahaan/{id}', [MasterDataController::class, 'updateBentukPerusahaan'])->name('bentuk-perusahaan.update');
    Route::delete('master-data/bentuk-perusahaan/{id}', [MasterDataController::class, 'destroyBentukPerusahaan'])->name('bentuk-perusahaan.destroy');

    Route::get('kelola-data-kadis', [MasterDataController::class, 'kelolaDataKadis'])->name('kelola-data-kadis.index');
    Route::get('kelola-data-kadis/create', [MasterDataController::class, 'createKelolaDataKadis'])->name('kelola-data-kadis.create');
    Route::post('kelola-data-kadis', [MasterDataController::class, 'storeKelolaDataKadis'])->name('kelola-data-kadis.store');
    Route::get('kelola-data-kadis/{id}/edit', [MasterDataController::class, 'editKelolaDataKadis'])->name('kelola-data-kadis.edit');
    Route::put('kelola-data-kadis/{id}', [MasterDataController::class, 'updateKelolaDataKadis'])->name('kelola-data-kadis.update');
    Route::delete('kelola-data-kadis/{id}', [MasterDataController::class, 'destroyKelolaDataKadis'])->name('kelola-data-kadis.destroy');

    Route::get('data-kbli', [MasterDataController::class, 'dataKBLI'])->name('data-kbli.index');
    Route::get('data-kbli/create', [MasterDataController::class, 'createDataKBLI'])->name('data-kbli.create');
    Route::post('data-kbli', [MasterDataController::class, 'storeDataKBLI'])->name('data-kbli.store');
    Route::get('data-kbli/{id}/edit', [MasterDataController::class, 'editDataKBLI'])->name('data-kbli.edit');
    Route::put('data-kbli/{id}', [MasterDataController::class, 'updateDataKBLI'])->name('data-kbli.update');
    Route::delete('data-kbli/{id}', [MasterDataController::class, 'destroyDataKBLI'])->name('data-kbli.destroy');

    Route::get('/tabel-referensi', [MasterDataController::class, 'tabelReferensi'])->name('tabel-referensi.index');
    Route::post('/tabel-referensi', [MasterDataController::class, 'storeTabelReferensi'])->name('tabel-referensi.store');
    Route::delete('/tabel-referensi/destroy/{id}', [MasterDataController::class, 'destroyTabelReferensi'])->name('tabel-referensi.destroy');
    Route::get('/tabel-referensi/{id}/kategori', [MasterDataController::class, 'kategori'])->name('kategori.index');
    Route::get('/kategori/create/{id}', [MasterDataController::class, 'createKategori'])->name('kategori.create');
    Route::post('/kategori/store/{id}', [MasterDataController::class, 'storeKategori'])->name('kategori.store');
    Route::get('/kategori/edit/{id}', [MasterDataController::class, 'editKategori'])->name('kategori.edit');
    Route::post('/kategori/update/{id}', [MasterDataController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/destroy/{id}', [MasterDataController::class, 'destroyKategori'])->name('kategori.destroy');

    Route::prefix('notifikasi')->group(function () {
        Route::get('master-notifikasi', [NotifikasiController::class, 'masterNotifikasi'])->name('notifikasi.master-notifikasi');
        Route::get('outbox', [NotifikasiController::class, 'outbox'])->name('notifikasi.outbox');
        Route::get('create', [NotifikasiController::class, 'create'])->name('notifikasi.create');
        Route::post('store', [NotifikasiController::class, 'store'])->name('notifikasi.store');
        Route::get('edit/{id}', [NotifikasiController::class, 'edit'])->name('notifikasi.edit');
        Route::put('update/{id}', [NotifikasiController::class, 'update'])->name('notifikasi.update');
        Route::delete('destroy/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    });

    Route::resource('master-notifikasi', NotifikasiController::class);
    Route::get('notifikasi/master', [NotifikasiController::class, 'masterNotifikasi'])->name('notifikasi.master');
    Route::get('notifikasi/outbox', [NotifikasiController::class, 'outbox'])->name('notifikasi.outbox');
    Route::get('notifikasi/outbox/create', [NotifikasiController::class, 'createOutbox'])->name('outbox.create');
    Route::post('notifikasi/outbox', [NotifikasiController::class, 'storeOutbox'])->name('outbox.store');
    Route::get('notifikasi/outbox/{id}/edit', [NotifikasiController::class, 'editOutbox'])->name('outbox.edit');
    Route::put('notifikasi/outbox/{id}', [NotifikasiController::class, 'updateOutbox'])->name('outbox.update');
    Route::delete('notifikasi/outbox/{id}', [NotifikasiController::class, 'destroyOutbox'])->name('outbox.destroy');

    Route::prefix('monitoring')->group(function () {
        Route::get('rekapitulasi-izin', [MonitoringController::class, 'rekapitulasiIzin'])->name('monitoring.rekapitulasi-izin');
        Route::get('monitoring-perizinan', [MonitoringController::class, 'monitoringPerizinan'])->name('monitoring.monitoring-perizinan');
        Route::get('jumlah-izin', [MonitoringController::class, 'jumlahIzin'])->name('monitoring.jumlah-izin');
        Route::get('data-arsip', [MonitoringController::class, 'dataArsip'])->name('monitoring.data-arsip');
        Route::get('monitoring-izin', [MonitoringController::class, 'monitoringIzin'])->name('monitoring.monitoring-izin');
        Route::get('izin-terbit', [MonitoringController::class, 'izinTerbit'])->name('monitoring.izin-terbit');
        Route::get('release-permohonan', [MonitoringController::class, 'releasePermohonan'])->name('monitoring.release-permohonan');
    });

    Route::get('monitoring/rekapitulasi-izin', [MonitoringController::class, 'rekapitulasiIzin'])->name('monitoring.rekapitulasi.izin');
    Route::get('monitoring/rekapitulasi-izin/process', [MonitoringController::class, 'processRekapitulasi'])->name('monitoring.rekapitulasi.process');
    Route::get('monitoring/rekapitulasi-izin/export/excel', [MonitoringController::class, 'exportToExcel'])->name('monitoring.rekapitulasi.export.excel');
    Route::get('monitoring/rekapitulasi-izin/export/pdf', [MonitoringController::class, 'exportToPdf'])->name('monitoring.rekapitulasi.export.pdf');
    Route::get('monitoring/rekapitulasi/process', [MonitoringController::class, 'rekapitulasiIzin'])->name('monitoring.rekapitulasi.process');

    Route::get('monitoring/dashboard-monitoring', [MonitoringController::class, 'monitoringDashboard'])->name('monitoring.dashboard');
    Route::get('monitoring/dashboard-monitoring/process', [MonitoringController::class, 'processDashboard'])->name('monitoring.dashboard.process');

    Route::get('monitoring/dashboard-frontoffice', [MonitoringController::class, 'monitoringPerizinanFO'])->name('monitoring.perizinanfo');
    // Route::get('monitoring/rekapitulasi-izin/export/excel', [MonitoringController::class, 'exportToExcel'])->name('monitoring.rekapitulasi.export.excel');
    // Route::get('monitoring/rekapitulasi-izin/export/pdf', [MonitoringController::class, 'exportToPdf'])->name('monitoring.rekapitulasi.export.pdf');
    // Route::get('monitoring/rekapitulasi/process', [MonitoringController::class, 'rekapitulasiIzin'])->name('monitoring.rekapitulasi.process');

    Route::get('/monitoring-perizinan', [MonitoringController::class, 'index'])->name('monitoring.perizinan.index');
    Route::get('/monitoring-perizinan/process', [MonitoringController::class, 'process'])->name('monitoring.perizinan.process');
    Route::get('/monitoring/perizinan', [MonitoringController::class, 'monitoringPerizinan'])->name('monitoring.perizinan');

    Route::get('/data-arsip', [MonitoringController::class, 'dataArsip'])->name('data-arsip.index');
    Route::get('/data-arsip/search', [MonitoringController::class, 'dataArsip'])->name('data-arsip.search');

    Route::get('/monitoring-izin', [MonitoringController::class, 'monitoringIzin'])->name('monitoring-izin.index');
    Route::get('/monitoring-izin/search', [MonitoringController::class, 'monitoringIzin'])->name('monitoring-izin.search');

    Route::get('/izin-terbit', [MonitoringController::class, 'izinTerbit'])->name('izin-terbit.index');
    Route::get('/izin-terbit/search', [MonitoringController::class, 'izinTerbit'])->name('izin-terbit.search');
    Route::get('/izin-terbit/view/{id}', [MonitoringController::class, 'viewIzin'])->name('izin-terbit.view');

    Route::get('/release-permohonan', [MonitoringController::class, 'releasePermohonan'])->name('release-permohonan.index');
    Route::get('/release-permohonan/search', [MonitoringController::class, 'releasePermohonan'])->name('release-permohonan.search');
    Route::post('/release-permohonan/update/{id}', [MonitoringController::class, 'updateReleasePermohonan'])->name('release-permohonan.update');

    Route::get('/laporan/query-builder', [LaporanController::class, 'queryBuilder'])->name('laporan.query-builder');
    Route::get('/laporan/export-excel', [LaporanExportController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf', [LaporanExportController::class, 'exportPDF'])->name('laporan.export-pdf');
    Route::get('/laporan/view-details/{id}', [LaporanController::class, 'viewDetails'])->name('laporan.view-details');

    Route::get('/skm/hasil-survey', [SKMController::class, 'hasilSurvey'])->name('skm.hasil-survey');
    Route::get('/skm/daftar-pertanyaan', [SKMController::class, 'daftarPertanyaan'])->name('skm.daftar-pertanyaan');

    Route::get('/skm/daftar-pertanyaan', [SKMController::class, 'daftarPertanyaan'])->name('skm.daftar-pertanyaan');
    Route::get('/skm/tambah-pertanyaan', [SKMController::class, 'tambahPertanyaan'])->name('skm.tambah-pertanyaan');
    Route::post('/skm/store-pertanyaan', [SKMController::class, 'storePertanyaan'])->name('skm.store-pertanyaan');
    Route::get('/skm/edit-pertanyaan/{id}', [SKMController::class, 'editPertanyaan'])->name('skm.edit-pertanyaan');
    Route::put('/skm/update-pertanyaan/{id}', [SKMController::class, 'updatePertanyaan'])->name('skm.update-pertanyaan');
    Route::delete('/skm/delete-pertanyaan/{id}', [SKMController::class, 'deletePertanyaan'])->name('skm.delete-pertanyaan');

    Route::get('/daftar-perizinan/manage/{id}', [\App\Http\Controllers\PengaturanController::class, 'manageDaftarPerizinan'])->name('daftar-perizinan.manage');

    Route::get('/api/verification-status/{pengajuanId}', [frontofficeController::class, 'getVerificationStatus'])->name('api.verification-status');
    Route::get('/api/verification-status/{pengajuanId}', [VerificationStatusController::class, 'getStatus']);
    Route::get('/api/dashboard-stats', [frontofficeController::class, 'getDashboardStats'])->name('api.dashboard-stats');
})->middleware(JabatanMiddleware::class);
