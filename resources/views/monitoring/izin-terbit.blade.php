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
            .page-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 2rem;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
            }
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
            .btn-primary {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                border: none;
                padding: 10px 25px;
                font-weight: 600;
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
            .btn-view {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                color: white;
                border: none;
                padding: 5px 15px;
                border-radius: 5px;
            }
            .btn-view:hover {
                opacity: 0.9;
            }
            .pdf-icon {
                color: #e74c3c;
                font-size: 1.2rem;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="page-title">
            <i class="fas fa-file-alt mr-2"></i>Pencarian Izin Terbit
        </h1>
        
        <div class="card card-filter shadow">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Pencarian</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('izin-terbit.search') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_izin_id" class="font-weight-bold">Jenis Izin</label>
                                <select class="form-control select2" name="jenis_izin_id" id="jenis_izin_id">
                                    <option value="">- Semua -</option>
                                    @foreach ($jenisIzins as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_izin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_awal" class="font-weight-bold">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_akhir" class="font-weight-bold">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search mr-2"></i>Proses
                            </button>
                            <a href="{{ route('izin-terbit.index') }}" class="btn btn-secondary">
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
                            <th>Resi Nama Pemohon</th>
                            <th>Perusahaan</th>
                            <th>Lokasi Izin</th>
                            <th>Jenis Izin</th>
                            <th>Tanggal Terbit</th>
                            <th>Berlaku s/d</th>
                            <th>No Izin</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataIzin as $index => $izin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $izin->resi_nama_pemohon }}</td>
                                <td>{{ $izin->perusahaan }}</td>
                                <td>{{ $izin->lokasi_izin }}</td>
                                <td>{{ $izin->jenisIzin->nama_jenis_izin }}</td>
                                <td>{{ $izin->tanggal_terbit }}</td>
                                <td>{{ $izin->berlaku_sampai }}</td>
                                <td>{{ $izin->no_izin }}</td>
                                <td>
                                    <a href="{{ asset('dokumen/' . $izin->dokumen_izin) }}" target="_blank">
                                        <i class="fas fa-file-pdf pdf-icon"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('izin-terbit.view', $izin->id) }}" class="btn btn-view">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
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

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Jenis Izin",
                allowClear: true
            });
        });
    </script>
@endsection
