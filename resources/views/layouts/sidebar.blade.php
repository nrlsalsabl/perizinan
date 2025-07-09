<div id="sidebar">
    @if (Auth::check())
        <header style="position: relative;">
            <a href="{{ route('dashboard') }}">
                <i class="zmdi zmdi-airplane"></i>
                <span class="menu-text">Dashboard</span>
            </a>
            <button id="sidebar-collapse-btn" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#fff;font-size:1.2rem;cursor:pointer;z-index:10;" title="Collapse Sidebar">
                <i class="zmdi zmdi-chevron-left"></i>
            </button>
        </header>
        <ul class="nav flex-column pe-5 me-5">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="zmdi zmdi-view-dashboard"></i> <span class="menu-text">Home</span>
                </a>
            </li>
            @if (Auth::user()->jabatan === 'admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="systemManagementDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-settings"></i> <span class="menu-text">System Management</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="systemManagementDropdown">
                        <a class="dropdown-item" href="{{ route('users.index') }}"><i class="zmdi zmdi-accounts"></i> <span class="menu-text">Users</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('roles.index') }}"><i class="zmdi zmdi-shield-security"></i> <span class="menu-text">Roles</span></a> --}}
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pengaturanDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-settings"></i> <span class="menu-text">Pengaturan</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pengaturanDropdown">
                        <a class="dropdown-item" href="{{ route('daftar-perizinan.index') }}"><i class="zmdi zmdi-assignment"></i> <span class="menu-text">Daftar Perizinan</span></a>
                        <a class="dropdown-item" href="{{ route('jenis-layanan.index') }}"><i class="zmdi zmdi-apps"></i> <span class="menu-text">Jenis Layanan</span></a>
                        <a class="dropdown-item" href="{{ route('jenis-layanan-izin.index') }}"><i class="zmdi zmdi-apps"></i> <span class="menu-text">Jenis Layanan Terhadap Izin</span></a>
                        <a class="dropdown-item" href="{{ route('jenis-persyaratan.index') }}"><i class="zmdi zmdi-format-list-bulleted"></i> <span class="menu-text">Jenis Persyaratan</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('workflow.index') }}"><i class="zmdi zmdi-shuffle"></i> <span class="menu-text">Workflow</span></a> --}}
                        <a class="dropdown-item" href="{{ route('template-izin.index') }}"><i class="zmdi zmdi-file-text"></i> <span class="menu-text">Template Izin</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('template-resi.index') }}"><i class="zmdi zmdi-receipt"></i> <span class="menu-text">Template Resi</span></a> --}}
                        <a class="dropdown-item" href="{{ route('informasi-perizinan.index') }}"><i class="zmdi zmdi-info-outline"></i> <span class="menu-text">Informasi Perizinan</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('setting-portal.index') }}"><i class="zmdi zmdi-settings"></i> <span class="menu-text">Setting Portal</span></a> --}}
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="masterDataDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-folder"></i> <span class="menu-text">Master Data</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="masterDataDropdown">
                        {{-- <a class="dropdown-item" href="{{ route('provinsi.index') }}"><i class="zmdi zmdi-city"></i> <span class="menu-text">Provinsi</span></a> --}}
                        <a class="dropdown-item" href="{{ route('kabupaten-kota.index') }}"><i class="zmdi zmdi-city-alt"></i> <span class="menu-text">Kabupaten Kota</span></a>
                        <a class="dropdown-item" href="{{ route('kecamatan.index') }}"><i class="zmdi zmdi-city"></i> <span class="menu-text">Kecamatan</span></a>
                        <a class="dropdown-item" href="{{ route('data-hari-libur.index') }}"><i class="zmdi zmdi-calendar"></i> <span class="menu-text">Data Hari Libur</span></a>
                        <a class="dropdown-item" href="{{ route('bentuk-perusahaan.index') }}"><i class="zmdi zmdi-balance"></i> <span class="menu-text">Bentuk Perusahaan</span></a>
                        <a class="dropdown-item" href="{{ route('kelola-data-kadis.index') }}"><i class="zmdi zmdi-accounts-list"></i> <span class="menu-text">Kelola Data Kadis</span></a>
                        <a class="dropdown-item" href="{{ route('data-kbli.index') }}"><i class="zmdi zmdi-label"></i> <span class="menu-text">Data KBLI</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('tabel-referensi.index') }}"><i class="zmdi zmdi-collection-item"></i> <span class="menu-text">Tabel Referensi</span></a> --}}
                    </div>
                </li>

                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="masterDataDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-folder"></i> Notifikasi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="masterDataDropdown">
                        <a class="dropdown-item" href="{{ route('master-notifikasi.index') }}">Master Notifikasi</a>
                        <a class="dropdown-item" href="{{ route('notifikasi.outbox') }}">Outbox</a>
                    </div>
                </li> --}}

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="monitoringAdminDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-monitor"></i> <span class="menu-text">Monitoring</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="monitoringAdminDropdown">
                        <a class="dropdown-item" href="{{ route('monitoring.rekapitulasi.izin') }}"><i class="zmdi zmdi-assignment-check"></i> <span class="menu-text">Rekapitulasi Izin</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('monitoring.monitoring-perizinan') }}"><i class="zmdi zmdi-eye"></i> <span class="menu-text">Monitoring Perizinan</span></a> --}}
                        <a class="dropdown-item" href="{{ route('monitoring.dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i> <span class="menu-text">Monitoring Dashboard</span></a>
                        <a class="dropdown-item" href="{{ route('monitoring.data-arsip') }}"><i class="zmdi zmdi-archive"></i> <span class="menu-text">Data Arsip</span></a>
                        {{-- <a class="dropdown-item" href="{{ route('monitoring.monitoring-izin') }}"><i class="zmdi zmdi-eye"></i> <span class="menu-text">Monitoring Izin</span></a> --}}
                        {{-- <a class="dropdown-item" href="{{ route('monitoring.izin-terbit') }}"><i class="zmdi zmdi-check"></i> <span class="menu-text">Izin Terbit</span></a> --}}
                        <a class="dropdown-item" href="{{ route('monitoring.release-permohonan') }}"><i class="zmdi zmdi-mail-send"></i> <span class="menu-text">Release Permohonan</span></a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-file-text"></i> <span class="menu-text">Laporan</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                        <a class="dropdown-item" href="{{ route('laporan.query-builder') }}"><i class="zmdi zmdi-search"></i> <span class="menu-text">Query Builder</span></a>
                    </div>
                </li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="skmDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-survey"></i> SKM
                    </a>
                    <div class="dropdown-menu" aria-labelledby="skmDropdown">
                        <a class="dropdown-item" href="{{ route('skm.hasil-survey') }}">Hasil Survey</a>
                        <a class="dropdown-item" href="{{ route('skm.daftar-pertanyaan') }}">Daftar Pertanyaan</a>
                    </div>
                </li> --}}
            @elseif (Auth::user()->jabatan === 'front end' || Auth::user()->jabatan === 'user')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan-permohonan.create') }}">
                        <i class="zmdi zmdi-plus-circle"></i> <span class="menu-text">Pengajuan Permohonan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('monitoring-frontend.index') }}">
                        <i class="zmdi zmdi-eye"></i> <span class="menu-text">Monitoring Izin</span>
                    </a>
                </li>
            @elseif (Auth::user()->jabatan === 'front office')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('verifikasi-pendaftaran.index') }}">
                        <i class="zmdi zmdi-check"></i> <span class="menu-text">Verifikasi Pendaftaran</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="monitoringFrontOfficeDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-monitor"></i> <span class="menu-text">Monitoring</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="monitoringFrontOfficeDropdown">
                        <a class="dropdown-item" href="{{ route('monitoring.dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i> <span class="menu-text">Monitoring Dashboard</span></a>
                        <a class="dropdown-item" href="{{ route('monitoring.perizinanfo') }}"><i class="zmdi zmdi-view-dashboard"></i> <span class="menu-text">Monitoring Perizinan</span></a>
                    </div>
                </li>
            @elseif (Auth::user()->jabatan === 'kasi')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('verifikasi-kasi.index') }}">
                        <i class="zmdi zmdi-check"></i> <span class="menu-text">Verifikasi Kasi</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="monitoringKasiDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-monitor"></i> <span class="menu-text">Monitoring</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="monitoringKasiDropdown">
                        <a class="dropdown-item" href="{{ route('monitoring.dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i> <span class="menu-text">Monitoring Dashboard</span></a>
                    </div>
                </li>
            @elseif (Auth::user()->jabatan === 'back office')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proses-backoffice.index') }}">
                        <i class="zmdi zmdi-settings"></i> <span class="menu-text">Proses Perizinan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('penyerahan-izin.index') }}">
                        <i class="zmdi zmdi-mail-send"></i> <span class="menu-text">Penyerahan Izin</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="monitoringBackOfficeDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="zmdi zmdi-monitor"></i> <span class="menu-text">Monitoring</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="monitoringBackOfficeDropdown">
                        <a class="dropdown-item" href="{{ route('monitoring.dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i> <span class="menu-text">Monitoring Dashboard</span></a>
                    </div>
                </li>
            @endif
        </ul>
    @endif
</div>
