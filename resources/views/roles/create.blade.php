@extends('layouts.app')

@section('head')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>


    </head>
@endsection

@section('content')
    <div class="container">
        <h1>Tambah Role Baru</h1>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" class="form-control" id="description" required>
            </div>

            <label for="daftar_akses">Daftar Akses</label>
            <div class="mb-2">
                <button type="button" id="select-all" class="btn btn-sm btn-primary">Select All</button>
                <button type="button" id="deselect-all" class="btn btn-sm btn-secondary">Deselect All</button>
            </div>
            <div class="form-group">
                <select class="select2 form-control" multiple="multiple" id="daftar_akses" name="daftar_akses[]">

                    <option value="home">Home</option>
                    <optgroup label="System Management">
                        <option value="users">Users</option>
                        <option value="roles">Roles</option>

                    </optgroup>
                    <optgroup label="Pengaturan">
                        <option value="daftarperizinan">Daftar Perizinan</option>
                        <option value="jenislayanan">Jenis Layanan</option>
                        <option value="jenislayananterhadapizin">Jenis Layanan
                            Terhadap Izin</option>
                        <option value="jenispersyaratan">Jenis Persyaratan</option>
                        <option value="workflow">Workflow</option>
                        <option value="templateizin">Template Izin</option>
                        <option value="templateresi">Template Resi</option>
                        <option value="informasiperizinan">Informasi Perizinan
                        </option>
                        <option value="settingportal">Setting Portal</option>
                    </optgroup>
                    <optgroup label="Master Data">
                    <optgroup label="&nbsp Master Alamat">
                        <option value="provinsi">Provinsi</option>
                        <option value="kabkot">Kabupatan Kota</option>
                        <option value="kecamatan">Kecamatan</option>
                    </optgroup>
                    <option value="dataharilibur">Data Hari Libur</option>
                    <option value="bentukperusahaan">Bentuk Perusahaan</option>
                    <option value="keloladatakadis">Kelola Data Kadis</option>
                    <option value="datakbli">Data KBLI</option>
                    <option value="tabelrefrensi">Tabel Refrensi
                    </option>
                    </optgroup>
                    <optgroup label="Notifikasi">
                        <option value="masternotifikasi">Master Notifikasi</option>
                        <option value="outbox">Outbox</option>
                    </optgroup>
                    <optgroup label="Monitoring">
                        <option value="dashboard">Dashboard</option>
                        <option value="rekapitulasiizin">Rekapitulasi Izin</option>
                        <option value="monitoringperzinan">Monitoring Perizinan</option>
                        <option value="dataarsip">Data Arsip</option>
                        <option value="monitoringizin">Monitoring Izin</option>
                        <option value="izinterbit">Izin Terbit</option>
                        <option value="releasepermohonan">Release Permohonan</option>
                    </optgroup>
                    <optgroup label="Laporan">
                        <option value="querybuilder">Query Builder</option>
                    </optgroup>
                    <optgroup label="SKM">
                        <option value="hasilsurvey">Hasil Survey</option>
                        <option value="daftarpertanyaan">Daftar Pertanyaan</option>
                    </optgroup>
                    <option value="verifikasipendaftaran">Verifikasi Pendaftaran</option>
                    <option value="penyerahanizin">Penyerahan Izin</option>
                    <option value="verifikasikasi">Verifikasi Kasi</option>
                    <option value="validasikasi">Validasi Kasi</option>
                    <option value="prosesperizinan">Proses Perizinan</option>
                    <option value="validasikadis">Validasi Kadis</option>
                    <option value="ttdizin">TTD Izin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="proses_izin">Proses Izin</label>
                <input type="text" name="proses_izin" class="form-control" id="proses_izin">
            </div>

            <div class="form-group">
                <label for="use_pin">Use PIN?</label>
                <select name="use_pin" class="form-control" id="use_pin">
                    <option value="Ya">Ya</option>
                    <option value="Tidak" selected>Tidak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var multiSelect = document.querySelector('#ms1');
            if (multiSelect) {
                new coreui.MultiSelect(multiSelect);
            }
        });
    </script> --}}
@endsection
