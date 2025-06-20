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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

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
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .table thead {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                color: white;
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
            .status-diterbitkan {
                background-color: #d4edda;
                color: #155724;
            }
            .status-ditolak {
                background-color: #f8d7da;
                color: #721c24;
            }
            .export-buttons {
                margin-bottom: 1rem;
            }
            .export-buttons .btn {
                margin-right: 0.5rem;
            }
            .search-box {
                margin-bottom: 1rem;
            }
            .date-range {
                background-color: #f8f9fa;
                padding: 1rem;
                border-radius: 5px;
                margin-bottom: 1rem;
            }
            .process-timeline {
                position: relative;
                padding: 20px 0;
            }
            .process-timeline::before {
                content: '';
                position: absolute;
                top: 0;
                left: 20px;
                height: 100%;
                width: 2px;
                background: #e9ecef;
            }
            .process-step {
                position: relative;
                padding-left: 50px;
                margin-bottom: 20px;
            }
            .process-step::before {
                content: '';
                position: absolute;
                left: 12px;
                top: 0;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                background: #fff;
                border: 2px solid #007bff;
            }
            .process-step.completed::before {
                background: #28a745;
                border-color: #28a745;
            }
            .process-step.current::before {
                background: #ffc107;
                border-color: #ffc107;
            }
            .process-step.pending::before {
                background: #fff;
                border-color: #6c757d;
            }
            .process-info {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 5px;
                margin-top: 10px;
            }
            .process-info p {
                margin-bottom: 5px;
            }
            .process-info .label {
                font-weight: bold;
                color: #495057;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="page-title">
            <i class="fas fa-search mr-2"></i>Query Builder Laporan
        </h1>
        
        <div class="card card-filter shadow">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Laporan</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.query-builder') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status_izin" class="font-weight-bold">Status Izin</label>
                                <select class="form-control select2" name="status_izin" id="status_izin">
                                    <option value="semua">- Semua Status -</option>
                                    <option value="Proses">Izin Dalam Proses</option>
                                    <option value="Cetak Izin">Izin Diterbitkan</option>
                                    <option value="Ditolak">Izin Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_permohonan" class="font-weight-bold">Jenis Permohonan</label>
                                <select class="form-control select2" name="jenis_permohonan" id="jenis_permohonan">
                                    <option value="semua">- Semua Jenis -</option>
                                    <option value="Perizinan Baru">Perizinan Baru</option>
                                    <option value="Perpanjang Perizinan">Perpanjang Perizinan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_izin" class="font-weight-bold">Jenis Izin</label>
                                <select class="form-control select2" name="jenis_izin" id="jenis_izin">
                                    <option value="">- Semua Izin -</option>
                                    @foreach ($jenisIzins as $jenis)
                                        <option value="{{ $jenis->nama_jenis_izin }}">{{ $jenis->nama_jenis_izin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_awal" class="font-weight-bold">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_akhir" class="font-weight-bold">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-submit text-white">
                                <i class="fas fa-search mr-2"></i>Proses
                            </button>
                            <a href="{{ route('laporan.query-builder') }}" class="btn btn-secondary">
                                <i class="fas fa-sync-alt mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (isset($results))
            <div class="export-buttons">
                <button class="btn btn-success" onclick="exportToExcel()">
                    <i class="fas fa-file-excel mr-2"></i>Export to Excel
                </button>
                <button class="btn btn-danger" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf mr-2"></i>Export to PDF
                </button>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover" id="resultsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Jenis Izin</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result->nama_pemohon }}</td>
                                <td>{{ $result->jenis_izin }}</td>
                                <td>{{ \Carbon\Carbon::parse($result->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if($result->proses_terakhir == 'Proses')
                                        <span class="status-badge status-proses">{{ $result->proses_terakhir }}</span>
                                    @elseif($result->proses_terakhir == 'Cetak Izin')
                                        <span class="status-badge status-diterbitkan">{{ $result->proses_terakhir }}</span>
                                    @elseif($result->proses_terakhir == 'Ditolak')
                                        <span class="status-badge status-ditolak">{{ $result->proses_terakhir }}</span>
                                    @else
                                        {{ $result->proses_terakhir }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $frontOfficeDone = \App\Models\requestPendaftaran::where('pengajuan_id', $result->pengajuan_id)
                                            ->where('role', 'Front Office')
                                            ->whereIn('proses_terakhir', ['Proses Kasi dan BackOffice', 'Ditolak'])
                                            ->exists();
                                        $kasiDone = \App\Models\requestPendaftaran::where('pengajuan_id', $result->pengajuan_id)
                                            ->where('role', 'Kasi')
                                            ->whereIn('proses_terakhir', ['Menunggu BackOffice', 'Ditolak'])
                                            ->exists();
                                        $backOfficeDone = \App\Models\requestPendaftaran::where('pengajuan_id', $result->pengajuan_id)
                                            ->where('role', 'Back Office')
                                            ->whereIn('proses_terakhir', ['Menunggu Kasi', 'Ditolak'])
                                            ->exists();
                                    @endphp

                                    @if($frontOfficeDone)
                                        <span class="badge badge-success">Front Office ✓</span>
                                    @else
                                        <span class="badge badge-warning">Front Office Pending</span>
                                    @endif
                                    
                                    @if($kasiDone)
                                        <span class="badge badge-success">Kasi ✓</span>
                                    @else
                                        <span class="badge badge-warning">Kasi Pending</span>
                                    @endif
                                    
                                    @if($backOfficeDone)
                                        <span class="badge badge-success">Back Office ✓</span>
                                    @else
                                        <span class="badge badge-warning">Back Office Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewDetails('{{ $result->id }}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal for Process Details -->
    <div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="processModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="processModalLabel">Detail Proses Perizinan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="process-timeline">
                        <div class="process-step completed">
                            <h6>Pendaftaran</h6>
                            <div class="process-info">
                                <p><span class="label">Tanggal:</span> <span id="pendaftaran-tanggal"></span></p>
                                <p><span class="label">Status:</span> <span id="pendaftaran-status"></span></p>
                            </div>
                        </div>
                        <div class="process-step" id="front-office-step">
                            <h6>Verifikasi Front Office</h6>
                            <div class="process-info">
                                <p><span class="label">Tanggal:</span> <span id="front-office-tanggal"></span></p>
                                <p><span class="label">Status:</span> <span id="front-office-status"></span></p>
                                <p><span class="label">Petugas:</span> <span id="front-office-petugas"></span></p>
                            </div>
                        </div>
                        <div class="process-step" id="kasi-step">
                            <h6>Verifikasi Kasi</h6>
                            <div class="process-info">
                                <p><span class="label">Tanggal:</span> <span id="kasi-tanggal"></span></p>
                                <p><span class="label">Status:</span> <span id="kasi-status"></span></p>
                                <p><span class="label">Petugas:</span> <span id="kasi-petugas"></span></p>
                            </div>
                        </div>
                        <div class="process-step" id="back-office-step">
                            <h6>Verifikasi Back Office</h6>
                            <div class="process-info">
                                <p><span class="label">Tanggal:</span> <span id="back-office-tanggal"></span></p>
                                <p><span class="label">Status:</span> <span id="back-office-status"></span></p>
                                <p><span class="label">Petugas:</span> <span id="back-office-petugas"></span></p>
                            </div>
                        </div>
                        <div class="process-step" id="final-step">
                            <h6>Penerbitan Izin</h6>
                            <div class="process-info">
                                <p><span class="label">Tanggal:</span> <span id="final-tanggal"></span></p>
                                <p><span class="label">Status:</span> <span id="final-status"></span></p>
                                <p><span class="label">Status Izin:</span> <span id="status-izin"></span></p>
                                <p><span class="label">Jenis Permohonan:</span> <span id="jenis-permohonan"></span></p>
                                <p><span class="label">Nomor Izin:</span> <span id="nomor-izin"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Initialize DataTable
            $('#resultsTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });

        function exportToExcel() {
            // Get current filter values
            const formData = new FormData(document.getElementById('filterForm'));
            const params = new URLSearchParams(formData);
            
            // Redirect to export endpoint with current filters
            window.location.href = `{{ route('laporan.export-excel') }}?${params.toString()}`;
        }

        function exportToPDF() {
            // Get current filter values
            const formData = new FormData(document.getElementById('filterForm'));
            const params = new URLSearchParams(formData);
            
            // Redirect to export endpoint with current filters
            window.location.href = `{{ route('laporan.export-pdf') }}?${params.toString()}`;
        }

        function viewDetails(id) {
            // Fetch process details
            $.get(`/laporan/view-details/${id}`, function(data) {
                // Update modal content with process details
                $('#pendaftaran-tanggal').text(formatDate(data.created_at));
                $('#pendaftaran-status').text('Selesai');

                // Front Office
                if (data.verifikasi_front_office) {
                    $('#front-office-step').addClass('completed');
                    $('#front-office-tanggal').text(formatDate(data.tanggal_verifikasi_front_office));
                    $('#front-office-status').text('Selesai');
                    $('#front-office-petugas').text(data.petugas_front_office);
                } else {
                    $('#front-office-step').addClass('current');
                    $('#front-office-tanggal').text('-');
                    $('#front-office-status').text('Menunggu');
                    $('#front-office-petugas').text('-');
                }

                // Kasi
                if (data.verifikasi_kasi) {
                    $('#kasi-step').addClass('completed');
                    $('#kasi-tanggal').text(formatDate(data.tanggal_verifikasi_kasi));
                    $('#kasi-status').text('Selesai');
                    $('#kasi-petugas').text(data.petugas_kasi);
                } else {
                    $('#kasi-step').addClass('pending');
                    $('#kasi-tanggal').text('-');
                    $('#kasi-status').text('Menunggu');
                    $('#kasi-petugas').text('-');
                }

                // Back Office
                if (data.verifikasi_back_office) {
                    $('#back-office-step').addClass('completed');
                    $('#back-office-tanggal').text(formatDate(data.tanggal_verifikasi_back_office));
                    $('#back-office-status').text('Selesai');
                    $('#back-office-petugas').text(data.petugas_back_office);
                } else {
                    $('#back-office-step').addClass('pending');
                    $('#back-office-tanggal').text('-');
                    $('#back-office-status').text('Menunggu');
                    $('#back-office-petugas').text('-');
                }

                // Final Step
                if (data.proses_terakhir === 'Cetak Izin') {
                    $('#final-step').addClass('completed');
                    $('#final-tanggal').text(formatDate(data.tanggal_terbit));
                    $('#final-status').text('Selesai');
                    $('#status-izin').html('<span class="status-badge status-diterbitkan">Diterbitkan</span>');
                    $('#jenis-permohonan').text(data.jenis_permohonan || '-');
                    $('#nomor-izin').text(data.nomor_izin);
                } else if (data.proses_terakhir === 'Ditolak') {
                    $('#final-step').addClass('completed');
                    $('#final-tanggal').text(formatDate(data.tanggal_terbit));
                    $('#final-status').text('Selesai');
                    $('#status-izin').html('<span class="status-badge status-ditolak">Ditolak</span>');
                    $('#jenis-permohonan').text(data.jenis_permohonan || '-');
                    $('#nomor-izin').text('-');
                } else {
                    $('#final-step').addClass('pending');
                    $('#final-tanggal').text('-');
                    $('#final-status').text('Menunggu');
                    $('#status-izin').html('<span class="status-badge status-proses">Dalam Proses</span>');
                    $('#jenis-permohonan').text(data.jenis_permohonan || '-');
                    $('#nomor-izin').text('-');
                }

                // Show modal
                $('#processModal').modal('show');
            });
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    </script>
@endsection
