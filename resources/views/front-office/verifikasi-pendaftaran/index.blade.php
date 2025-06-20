@extends('layouts.app')

@section('title', 'Verifikasi Pendaftaran')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <style>
            .verification-card {
                background: white;
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
                margin-bottom: 20px;
                border: none;
            }
            .verification-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            }
            .verification-header {
                background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
                color: white;
                border-radius: 10px 10px 0 0 !important;
                padding: 15px 20px;
            }
            .verification-body {
                padding: 20px;
            }
            .badge-status {
                font-size: 0.8rem;
                padding: 5px 10px;
                border-radius: 50px;
            }
            .action-btn {
                border-radius: 50px;
                padding: 8px 20px;
                font-weight: 500;
                transition: all 0.3s;
            }
            .detail-label {
                font-weight: 600;
                color: #495057;
            }
            .detail-value {
                color: #212529;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: #3f37c9; font-weight: 700;">
                <i class="fas fa-clipboard-check mr-2"></i>Verifikasi Pendaftaran
            </h2>
        </div>

        <div class="row">
            @foreach ($pendaftaran as $pendaftarans)
            <div class="col-md-12 mb-4">
                <div class="card verification-card">
                    <div class="card-header verification-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i>{{ $pendaftarans->resi }}</h5>
                        </div>
                        <div>
                            <span class="badge badge-status bg-light text-dark">
                                <i class="fas fa-clock mr-1"></i>{{ $pendaftarans->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body verification-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="detail-label">Proses Terakhir</p>
                                <p class="detail-value"><strong>{{ $pendaftarans->proses_terakhir }}</strong></p>
                                <p class="text-muted small">Oleh: {{ $pendaftarans->nama_pemohon }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="detail-label">Catatan</p>
                                <p class="detail-value">{{ $pendaftarans->catatan ?: '-' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="detail-label">Data Permohonan</p>
                                <p class="detail-value">
                                    <span class="d-block"><strong>Jenis Izin:</strong> {{ $pendaftarans->jenis_izin }}</span>
                                    <span class="d-block"><strong>Layanan:</strong> {{ $pendaftarans->jenis_permohonan }}</span>
                                </p>
                            </div>
                            <div class="col-md-3 d-flex align-items-center justify-content-end">
                                <a href="{{ route('verifikasi-pendaftaran.detail', $pendaftarans->id) }}" 
                                   class="btn action-btn btn-primary">
                                    <i class="fas fa-eye mr-2"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
