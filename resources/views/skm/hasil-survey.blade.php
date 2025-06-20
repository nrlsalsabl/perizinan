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
        <h1>Laporan Indeks Kepuasan Masyarakat</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('skm.hasil-survey') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="tanggal_awal">Tanggal Awal</label>
                    <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal"
                        value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3">
                    <label for="jenis_izin">Jenis Izin</label>
                    <select class="form-control" name="jenis_izin" id="jenis_izin">
                        <option value="">- Semua -</option>
                        @foreach ($jenisIzins as $izin)
                            <option value="{{ $izin->id }}" {{ request('jenis_izin') == $izin->id ? 'selected' : '' }}>
                                {{ $izin->nama_jenis_izin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </div>
        </form>

        <br>

        <!-- Survey Results Table -->
        @if ($surveys->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Responden</th>
                        <th>Jenis Izin</th>
                        <th>Nilai Kepuasan</th>
                        <th>Tanggal Survey</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveys as $index => $survey)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $survey->responden }}</td>
                            <td>{{ $survey->jenisIzin->nama_jenis_izin }}</td>
                            <td>{{ $survey->nilai_kepuasan }}</td>
                            <td>{{ $survey->tanggal_survey }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada hasil survey yang ditemukan.</p>
        @endif
    </div>
@endsection
