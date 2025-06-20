@extends('layouts.app')

@section('title', 'Monitoring Perizinan')

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
    <div class="container mt-4">
        <h1 class="mb-4">Monitoring Perizinan</h1>

        <form action="{{ route('monitoring.perizinan.process') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="tanggal_awal">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="jenis_izin">Jenis Izin</label>
                <select name="jenis_izin" id="jenis_izin" class="form-control">
                    <option value="">-Semua-</option>
                    @foreach ($jenisIzins as $data)
                        <option value="{{ $data->id }}">{{ $data->nama_jenis_izin }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        @if (isset($dataIzin) && $dataIzin->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Resi</th>
                        <th>Pemohon</th>
                        <th>Perusahaan</th>
                        <th>Jenis Izin</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataIzin as $index => $izin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $izin->resi }}</td>
                            <td>{{ $izin->nama_pemohon }}</td>
                            <td>{{ $izin->perusahaan }}</td>
                            <td>{{ $izin->jenisIzin->nama_jenis_izin }}</td>
                            <td>{{ $izin->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($izin->tanggal_pengajuan)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="mt-4">Tidak ada data perizinan yang ditemukan untuk kriteria yang dipilih.</p>
        @endif
    </div>
@endsection
