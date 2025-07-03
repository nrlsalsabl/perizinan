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
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .status-badge {
                padding: 5px 10px;
                border-radius: 20px;
                font-weight: 600;
            }
            .btn-detail {
                background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
                border: none;
                color: white;
            }
            .search-box {
                border-radius: 20px;
                padding: 10px 20px;
                border: 1px solid #ddd;
            }
            .search-btn {
                border-radius: 0 20px 20px 0;
                background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
                color: white;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="page-title">
            <i class="fas fa-clipboard-list mr-2"></i>Data Request Perizinan
        </h1>

        <div class="card card-filter shadow mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('monitoring-frontend.index') }}">
                    <div class="input-group">
                        <input type="text" class="form-control search-box" name="search" placeholder="Cari permohonan..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn search-btn" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Resi</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Izin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reject as $index => $rejects)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $rejects->resi }}</strong></td>
                            <td>{{ $rejects->nama_pemohon }}</td>
                            <td>{{ $rejects->jenis_izin }}</td>
                            <td>
                                <span class="status-badge 
                                    @if($rejects->proses_terakhir === 'Cetak Izin') bg-success text-white
                                    @elseif($rejects->proses_terakhir === 'Ditolak') bg-danger
                                    @else bg-warning text-dark @endif">
                                    {{ $rejects->proses_terakhir }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('monitoring-frontend.show', $rejects->pengajuan_id) }}"
                                    class="btn btn-detail btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
