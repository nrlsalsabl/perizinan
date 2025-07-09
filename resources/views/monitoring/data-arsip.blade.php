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
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="page-title">
            <i class="fas fa-archive mr-2"></i>Data Arsip
        </h1>
        
        <div class="card card-filter shadow">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Data</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('data-arsip.search') }}" class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nik_npwp" class="font-weight-bold">NIK/NPWP</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" name="nik_npwp" class="form-control" id="nik_npwp" placeholder="Masukkan NIK/NPWP">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nama_pemohon" class="font-weight-bold">Nama Pemohon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="nama_pemohon" class="form-control" id="nama_pemohon" placeholder="Masukkan Nama Pemohon">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nama_perusahaan" class="font-weight-bold">Nama Perusahaan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" placeholder="Masukkan Nama Perusahaan">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-submit text-white">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                        <a href="{{ route('data-arsip.index') }}" class="btn btn-secondary">
                            <i class="fas fa-sync-alt mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($dataArsip->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Account</th>
                            <th>NIK/NPWP</th>
                            <th>Nama Pemohon</th>
                            <th>Alamat</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat Perusahaan</th>
                            {{-- <th>Izin</th>
                            <th>Arsip</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataArsip as $index => $arsip)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $arsip->account }}</td>
                                <td>{{ $arsip->nik_npwp }}</td>
                                <td>{{ $arsip->nama_pemohon }}</td>
                                <td>{{ $arsip->alamat }}</td>
                                <td>{{ $arsip->nama_perusahaan }}</td>
                                <td>{{ $arsip->alamat_perusahaan }}</td>
                                {{-- <td>{{ $arsip->izin }}</td>
                                <td>{{ $arsip->arsip }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>Tidak ada data arsip ditemukan.
            </div>
        @endif
    </div>
@endsection
