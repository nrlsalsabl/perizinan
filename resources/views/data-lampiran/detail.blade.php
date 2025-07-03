@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Detail Lampiran')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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

            .info-card {
                background: white;
                padding: 2rem;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-bottom: 2rem;
            }

            .info-row {
                display: flex;
                align-items: center;
                padding: 1rem 0;
                border-bottom: 1px solid #e9ecef;
            }

            .info-row:last-child {
                border-bottom: none;
            }

            .info-label {
                flex: 0 0 30%;
                font-weight: 600;
                color: #2c3e50;
                margin-right: 1rem;
            }

            .info-value {
                flex: 1;
                color: #555;
            }

            .file-preview {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .file-link {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
                background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
                color: white;
                text-decoration: none;
                border-radius: 6px;
                font-size: 0.875rem;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .file-link:hover {
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .file-link i {
                font-size: 1rem;
            }

            .back-btn {
                background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
                border: none;
                padding: 0.75rem 2rem;
                border-radius: 6px;
                font-weight: 600;
                color: white;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
            }

            .back-btn:hover {
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 1.5rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid #1abc9c;
            }

            .alert {
                border-radius: 8px;
                border: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .alert-success {
                background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
                color: #155724;
            }

            .badge {
                padding: 0.5rem 0.75rem;
                border-radius: 4px;
                font-size: 0.875rem;
            }

            .badge-info {
                background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
                color: white;
            }

            .file-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1rem;
                margin-top: 1rem;
            }

            .file-item {
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
                border: 1px solid #e9ecef;
            }

            .file-item-label {
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
            }

            @media (max-width: 768px) {
                .container {
                    margin: 1rem auto;
                }

                .header {
                    padding: 1.5rem;
                }

                .info-card {
                    padding: 1.5rem;
                }

                .info-row {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .info-label {
                    flex: none;
                    margin-bottom: 0.5rem;
                }

                .file-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h1>Detail Data Lampiran</h1>
            <p class="mb-0">Informasi lengkap dokumen persyaratan permohonan izin</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Informasi Permohonan -->
        <div class="info-card">
            <div class="section-title">Informasi Permohonan</div>
            
            <div class="info-row">
                <div class="info-label">Tanggal Permohonan</div>
                <div class="info-value">
                    <span class="badge badge-info">{{ $lampiran->tgl_permohonan }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Nomor Surat</div>
                <div class="info-value">{{ $lampiran->nomor_surat }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Nama Pemohon</div>
                <div class="info-value">{{ $lampiran->nama }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Jenis Usaha</div>
                <div class="info-value">{{ $lampiran->jenis_usaha }}</div>
            </div>
        </div>

        <!-- Dokumen Persyaratan -->
        <div class="info-card">
            <div class="section-title">Dokumen Persyaratan</div>
            
            <div class="file-grid">
                <div class="file-item">
                    <div class="file-item-label">Surat Permohonan</div>
                    <a href="{{ asset('storage/' . $lampiran->surat_permohonan) }}" target="_blank" class="file-link">
                        <i class="fas fa-file-pdf"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">KTP Direktur</div>
                    <a href="{{ asset('storage/' . $lampiran->ktp_dir) }}" target="_blank" class="file-link">
                        <i class="fas fa-id-card"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">NIB OSS</div>
                    <a href="{{ asset('storage/' . $lampiran->nib_oss) }}" target="_blank" class="file-link">
                        <i class="fas fa-certificate"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Izin Usaha</div>
                    <a href="{{ asset('storage/' . $lampiran->izin_usaha) }}" target="_blank" class="file-link">
                        <i class="fas fa-file-contract"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Akta Perusahaan</div>
                    <a href="{{ asset('storage/' . $lampiran->akta_per) }}" target="_blank" class="file-link">
                        <i class="fas fa-building"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Profil Perusahaan</div>
                    <a href="{{ asset('storage/' . $lampiran->profil_per) }}" target="_blank" class="file-link">
                        <i class="fas fa-briefcase"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">NPWP Kaltim</div>
                    <a href="{{ asset('storage/' . $lampiran->npwp_kaltim) }}" target="_blank" class="file-link">
                        <i class="fas fa-receipt"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Surat Domisili</div>
                    <a href="{{ asset('storage/' . $lampiran->surat_domisili) }}" target="_blank" class="file-link">
                        <i class="fas fa-home"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Sertifikat Badan Usaha</div>
                    <a href="{{ asset('storage/' . $lampiran->sertif_badan) }}" target="_blank" class="file-link">
                        <i class="fas fa-award"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Rencana Pengembangan</div>
                    <a href="{{ asset('storage/' . $lampiran->rencana_peng) }}" target="_blank" class="file-link">
                        <i class="fas fa-chart-line"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Surat Penetapan PJT</div>
                    <a href="{{ asset('storage/' . $lampiran->surat_pene) }}" target="_blank" class="file-link">
                        <i class="fas fa-user-tie"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Sertifikat Kompetensi</div>
                    <a href="{{ asset('storage/' . $lampiran->sertif_kompeten) }}" target="_blank" class="file-link">
                        <i class="fas fa-medal"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Sertifikat ISO</div>
                    <a href="{{ asset('storage/' . $lampiran->sertif_iso) }}" target="_blank" class="file-link">
                        <i class="fas fa-star"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Standard Operating Procedure</div>
                    <a href="{{ asset('storage/' . $lampiran->sop) }}" target="_blank" class="file-link">
                        <i class="fas fa-clipboard-list"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Daftar Peralatan</div>
                    <a href="{{ asset('storage/' . $lampiran->peralatan_sewa) }}" target="_blank" class="file-link">
                        <i class="fas fa-tools"></i> Lihat Dokumen
                    </a>
                </div>

                <div class="file-item">
                    <div class="file-item-label">Surat Kuasa</div>
                    <a href="{{ asset('storage/' . $lampiran->surat_kuasa) }}" target="_blank" class="file-link">
                        <i class="fas fa-handshake"></i> Lihat Dokumen
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="text-center">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    @endsection