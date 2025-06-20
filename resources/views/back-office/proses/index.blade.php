@extends('layouts.app')

@section('title', 'Proses Perizinan')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
                color: #333;
                line-height: 1.6;
            }

            .container {
                max-width: 1200px;
                margin: 2rem auto;
                padding: 0 1rem;
            }

            .header {
                background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
                color: white;
                padding: 2rem;
                text-align: center;
                border-radius: 10px;
                margin-bottom: 2rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .header h1 {
                margin: 0;
                font-size: 2rem;
                font-weight: 600;
            }

            .table-container {
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                overflow: hidden;
                margin-bottom: 2rem;
            }

            .table {
                margin-bottom: 0;
            }

            .table thead th {
                background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
                color: white;
                border: none;
                padding: 1.2rem 1rem;
                font-weight: 600;
                font-size: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .table tbody td {
                padding: 1.2rem 1rem;
                vertical-align: middle;
                border-bottom: 1px solid #eee;
                font-size: 0.95rem;
            }

            .table tbody tr:hover {
                background-color: #f8f9fa;
            }

            .btn-warning {
                background: linear-gradient(135deg, #f1c40f 0%, #f39c12 100%);
                border: none;
                padding: 0.6rem 1.2rem;
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.3s ease;
                color: white;
                text-transform: uppercase;
                font-size: 0.9rem;
                letter-spacing: 0.5px;
            }

            .btn-warning:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                color: white;
            }

            .status-badge {
                padding: 0.6rem 1.2rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.9rem;
                display: inline-block;
                text-align: center;
                min-width: 120px;
            }

            .status-pending {
                background: linear-gradient(135deg, #f1c40f 0%, #f39c12 100%);
                color: white;
            }

            .status-approved {
                background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
                color: white;
            }

            .status-rejected {
                background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
                color: white;
            }

            .data-info {
                background: #f8f9fa;
                padding: 0.8rem;
                border-radius: 6px;
                margin-bottom: 0.5rem;
            }

            .data-info strong {
                color: #2c3e50;
                font-weight: 600;
            }

            .text-muted {
                color: #7f8c8d !important;
            }

            @media (max-width: 768px) {
                .container {
                    margin: 1rem auto;
                }

                .header {
                    padding: 1.5rem;
                }

                .header h1 {
                    font-size: 1.5rem;
                }

                .table thead th {
                    padding: 1rem 0.5rem;
                    font-size: 0.9rem;
                }

                .table tbody td {
                    padding: 1rem 0.5rem;
                    font-size: 0.9rem;
                }

                .status-badge {
                    min-width: 100px;
                    padding: 0.5rem 1rem;
                }
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h1>Proses Perizinan</h1>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Proses Sebelumnya</th>
                            <th>Catatan</th>
                            <th>Data Permohonan</th>
                            <th>Identitas Pemohon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftaran as $pendaftarans)
                            <tr>
                                <td>
                                    <a href="{{ route('proses-backoffice.detail', $pendaftarans->id) }}" class="btn btn-warning">Detail</a>
                                </td>
                                <td>
                                    <div class="status-badge {{ strtolower($pendaftarans->proses_terakhir) === 'ditolak' ? 'status-rejected' : 'status-pending' }}">
                                        {{ $pendaftarans->proses_terakhir }}
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Oleh: {{ $pendaftarans->nama_pemohon }}</small><br>
                                        <small class="text-muted">{{ $pendaftarans->created_at }}</small>
                                    </div>
                                </td>
                                <td>{{ $pendaftarans->catatan }}</td>
                                <td>
                                    <div class="data-info">
                                        <strong>Resi:</strong> {{ $pendaftarans->resi }}
                                    </div>
                                    <div class="data-info">
                                        <strong>Jenis Izin:</strong> {{ $pendaftarans->jenis_izin }}
                                    </div>
                                    <div class="data-info">
                                        <strong>Jenis Layanan:</strong> {{ $pendaftarans->jenis_permohonan }}
                                    </div>
                                </td>
                                <td>{{ $pendaftarans->nama_pemohon }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
