@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <style>
            .card-filter {
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                margin-bottom: 2rem;
            }
            .card-header {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                color: white;
                border-radius: 10px 10px 0 0 !important;
            }
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .table thead {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                color: white;
            }
            .btn-submit {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                border: none;
                padding: 10px 25px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }
            .form-control {
                border-radius: 5px;
                padding: 10px 15px;
            }
            .page-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 2rem;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
            }
            .status-badge {
                padding: 5px 10px;
                border-radius: 20px;
                font-weight: 600;
            }
            .status-proses {
                background-color: #fff3cd;
                color: #856404;
            }
            .status-selesai {
                background-color: #d4edda;
                color: #155724;
            }
            .status-ditolak {
                background-color: #f8d7da;
                color: #721c24;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="page-title">
            <i class="fas fa-chart-line mr-2"></i>Monitoring Perizinan
        </h1>
        
        <div class="card card-filter shadow">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Data</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('monitoring-izin.search') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="display" class="font-weight-bold">Display</label>
                                <select class="form-control" name="display" id="display">
                                    <option value="10">10 records</option>
                                    <option value="25">25 records</option>
                                    <option value="50">50 records</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tanggal_awal" class="font-weight-bold">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tanggal_akhir" class="font-weight-bold">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_izin_id" class="font-weight-bold">Jenis Izin</label>
                                <select class="form-control" name="jenis_izin_id" id="jenis_izin_id">
                                    <option value="">- Semua -</option>
                                    @foreach ($jenisIzins as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_izin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search" class="font-weight-bold">Search</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="search" id="search" placeholder="Cari Nama Pemohon">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-submit text-white">
                                <i class="fas fa-search mr-2"></i>Proses
                            </button>
                            <a href="{{ route('monitoring-izin.index') }}" class="btn btn-secondary">
                                <i class="fas fa-sync-alt mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($dataIzin->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Jenis Izin</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataIzin as $index => $izin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $izin->nama_pemohon }}</td>
                                <td>{{ $izin->jenisIzin->nama_jenis_izin }}</td>
                                <td>{{ \Carbon\Carbon::parse($izin->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-badge 
                                        @if(str_contains($izin->status, 'Proses')) status-proses
                                        @elseif(str_contains($izin->status, 'Selesai')) status-selesai
                                        @elseif(str_contains($izin->status, 'Ditolak')) status-ditolak
                                        @endif">
                                        {{ $izin->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>Tidak ada data izin ditemukan.
            </div>
        @endif
    </div>
@endsection
