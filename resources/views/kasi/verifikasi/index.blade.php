@extends('layouts.app')

@section('title', 'Verifikasi Kasi')

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

            .table thead th {
                background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
                color: white;
                border: none;
                padding: 1.2rem 1rem;
                font-weight: 600;
                font-size: 1rem;
                text-transform: uppercase;
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

            .text-muted {
                color: #7f8c8d !important;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h1>Verifikasi Kasi</h1>
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
                            <th>Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $pengajuanIds = $pendaftaran->pluck('pengajuan_id')->unique()->values(); @endphp
                        @foreach ($pendaftaran as $item)
                            <tr>
                                <td class="align-baseline"><a href="{{ route('verifikasi-kasi.detail', $item->id) }}"
                                        class="btn btn-warning">Detail</a></td>
                                <td class="align-baseline">
                                    <div
                                        class="status-badge {{ strtolower($item->proses_terakhir) === 'ditolak' ? 'status-rejected' : 'status-pending' }}">
                                        {{ $item->proses_terakhir }}</div>
                                    <div class="mt-2">
                                        <small class="text-muted">Oleh: {{ $item->nama_pemohon }}</small><br>
                                        <small class="text-muted">{{ $item->created_at }}</small>
                                    </div>
                                </td>
                                <td>{{ $item->catatan }}</td>
                                <td>
                                    <div><strong>Resi:</strong> {{ $item->resi }}</div>
                                    <div><strong>Jenis Izin:</strong> {{ $item->jenis_izin }}</div>
                                    <div><strong>Layanan:</strong> {{ $item->jenis_permohonan }}</div>
                                </td>
                                <td>{{ $item->nama_pemohon }}</td>
                                <td>
                                    <div id="status-frontoffice-{{ $item->pengajuan_id }}"></div>
                                    <div id="status-kasi-{{ $item->pengajuan_id }}"></div>
                                    <div id="status-backoffice-{{ $item->pengajuan_id }}"></div>
                                    <div id="status-final-{{ $item->pengajuan_id }}"></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script>
        const pengajuanIds = @json($pengajuanIds);

        pengajuanIds.forEach(pengajuanId => {
            fetch(`/api/verification-status-kasi/${pengajuanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`status-frontoffice-${pengajuanId}`).innerHTML =
                        `<span class="badge ${data.frontoffice === 'Terverifikasi' ? 'badge-success' : (data.frontoffice === 'Ditolak' ? 'badge-danger' : 'badge-warning')}">Front Office: ${data.frontoffice}</span>`;
                    document.getElementById(`status-kasi-${pengajuanId}`).innerHTML =
                        `<span class="badge ${data.kasi === 'Terverifikasi' ? 'badge-success' : (data.kasi === 'Ditolak' ? 'badge-danger' : 'badge-warning')}">Kasi: ${data.kasi}</span>`;
                    document.getElementById(`status-backoffice-${pengajuanId}`).innerHTML =
                        `<span class="badge ${data.backoffice === 'Terverifikasi' ? 'badge-success' : (data.backoffice === 'Ditolak' ? 'badge-danger' : 'badge-warning')}">Back Office: ${data.backoffice}</span>`;

                    const finalText = (
                            data.frontoffice === 'Terverifikasi' &&
                            data.kasi === 'Terverifikasi' &&
                            (data.backoffice === 'Terverifikasi' || data.backoffice === 'Cetak Izin')
                        ) ? 'Siap Cetak Izin' :
                        (data.frontoffice === 'Ditolak' || data.kasi === 'Ditolak' || data.backoffice ===
                            'Ditolak') ?
                        'Permohonan Ditolak' :
                        'Menunggu Semua Verifikasi';


                    const finalClass = (finalText === 'Siap Cetak Izin') ?
                        'badge-success' :
                        (finalText === 'Permohonan Ditolak') ?
                        'badge-danger' :
                        'badge-info';

                    document.getElementById(`status-final-${pengajuanId}`).innerHTML =
                        `<span class="badge ${finalClass}">Status: ${finalText}</span>`;
                });
        });
    </script>

@endsection
