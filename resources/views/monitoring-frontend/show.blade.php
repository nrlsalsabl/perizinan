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
            :root {
                --primary-color: #2c3e50;
                --secondary-color: #3498db;
                --success-color: #27ae60;
                --danger-color: #e74c3c;
                --warning-color: #f39c12;
                --light-color: #ecf0f1;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
            }

            .page-title {
                color: var(--primary-color);
                font-weight: 700;
                margin-bottom: 2rem;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
            }

            .info-card {
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
                border: none;
                overflow: hidden;
            }

            .info-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            }

            .info-card-header {
                padding: 15px 20px;
                font-weight: 600;
                color: white;
                font-size: 1.2rem;
            }

            .info-card-body {
                padding: 20px;
                background: white;
            }

            .info-item {
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eee;
            }

            .info-item:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }

            .info-label {
                font-weight: 600;
                color: var(--primary-color);
                display: block;
                margin-bottom: 5px;
            }

            .info-value {
                color: #555;
            }

            .timeline-card {
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .timeline-item {
                position: relative;
                padding-left: 30px;
                margin-bottom: 20px;
            }

            .timeline-item:before {
                content: '';
                position: absolute;
                left: 0;
                top: 5px;
                width: 15px;
                height: 15px;
                border-radius: 50%;
                background: var(--secondary-color);
            }

            .timeline-item:after {
                content: '';
                position: absolute;
                left: 7px;
                top: 20px;
                bottom: -25px;
                width: 1px;
                background: #ddd;
            }

            .timeline-item:last-child:after {
                display: none;
            }

            .timeline-date {
                font-size: 0.85rem;
                color: #777;
                margin-bottom: 5px;
            }

            .timeline-content {
                font-size: 0.95rem;
            }

            .file-item {
                display: flex;
                align-items: center;
                padding: 10px;
                border-radius: 5px;
                background: #f8f9fa;
                margin-bottom: 10px;
            }

            .file-item i {
                margin-right: 10px;
                color: var(--secondary-color);
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container py-4">
        <h1 class="page-title">
            <i class="fas fa-clipboard-check mr-2"></i>Detail Monitoring Permohonan
        </h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="info-card h-100">
                    <div class="info-card-header bg-primary">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Permohonan
                    </div>
                    <div class="info-card-body">
                        <div class="info-item">
                            <span class="info-label">No. Resi</span>
                            <span class="info-value">{{ $reject->resi }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Permohonan</span>
                            <span class="info-value">{{ $reject->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nama Pemohon</span>
                            <span class="info-value">{{ $reject->nama_pemohon }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Izin</span>
                            <span class="info-value">{{ $reject->jenis_izin }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Layanan</span>
                            <span class="info-value">{{ $reject->jenis_permohonan }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status Terakhir</span>
                            <span class="info-value badge 
                                @if($reject->proses_terakhir === 'Cetak Izin') bg-success
                                @elseif($reject->proses_terakhir === 'Ditolak') bg-danger
                                @else bg-warning @endif">
                                {{ $reject->proses_terakhir }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="info-card timeline-card h-100">
                    <div class="info-card-header bg-info">
                        <i class="fas fa-history mr-2"></i>Riwayat Proses
                    </div>
                    <div class="info-card-body flex-grow-1">
                        @foreach ($detail as $details)
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    {{ $details->created_at->format('d M Y H:i') }}
                                </div>
                                <div class="timeline-content">
                                    {{ $details->proses_terakhir }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="info-card h-100">
                    <div class="info-card-header bg-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>Catatan Penolakan
                    </div>
                    <div class="info-card-body">
                        <div class="mb-3">
                            @if (!empty($penolakan->catatan_umum))
                                <p class="font-weight-bold">{{ $penolakan->catatan_umum }}</p>
                            @else
                                <p class="text-muted">Belum ada catatan</p>
                            @endif
                        </div>
                        
                        <h6 class="font-weight-bold mb-3">Dokumen Terkait:</h6>
                        @if ($file->isNotEmpty())
                            @foreach ($file as $files)
                                <div class="file-item">
                                    <i class="fas fa-file-alt"></i>
                                    <span>{{ $files->nama_file }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada dokumen</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
