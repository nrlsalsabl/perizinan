<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Detail Data Lampiran</h2>
    </x-slot>

    <x-breadcrumb title="Detail Lampiran" :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Data Permohonan', 'url' => route('pengajuan.index')],
        ['label' => 'Detail']
    ]" />

    <div class="space-y-6">
        <div class="p-0 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            @if (session('success'))
                <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-100">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border">
                    <tbody class="text-gray-700 dark:text-gray-300">
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Tanggal Permohonan</th><td class="px-6 py-4">{{ $lampiran->tgl_permohonan }}</td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Nomor Surat</th><td class="px-6 py-4">{{ $lampiran->nomor_surat }}</td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Nama</th><td class="px-6 py-4">{{ $lampiran->nama }}</td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Jenis Usaha</th><td class="px-6 py-4">{{ $lampiran->jenis_usaha }}</td></tr>

                        {{-- File --}}
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Surat Permohonan</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->surat_permohonan) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">KTP Direktur</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->ktp_dir) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">NIB OSS</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->nib_oss) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Izin Usaha</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->izin_usaha) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Akta Perusahaan</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->akta_per) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Profil Perusahaan</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->profil_per) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">NPWP Kaltim</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->npwp_kaltim) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Surat Domisili</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->surat_domisili) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Sertifikat Badan Usaha</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->sertif_badan) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Rencana Penggunaan</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->rencana_peng) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Surat Pernyataan</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->surat_pene) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Sertifikat Kompetensi</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->sertif_kompeten) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Sertifikat ISO</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->sertif_iso) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">SOP</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->sop) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Peralatan Sewa</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->peralatan_sewa) }}" target="_blank">Lihat File</a></td></tr>
                        <tr><th class="px-6 py-4 font-medium bg-gray-100 dark:bg-gray-700">Surat Kuasa</th><td class="px-6 py-4"><a class="text-blue-500 underline" href="{{ asset('storage/' . $lampiran->surat_kuasa) }}" target="_blank">Lihat File</a></td></tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('dashboard') }}">
                    <x-button variant="primary">Kembali ke Dashboard</x-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
