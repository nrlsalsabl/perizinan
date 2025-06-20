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

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <style>
            .dashboard-container {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                padding: 2rem;
            }
            .title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 2rem;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
            }
            .summary-card {
                background: white;
                border: none;
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                text-align: center;
            }
            .summary-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #3498db;
                margin: 0.5rem 0;
            }
            .summary-label {
                color: #7f8c8d;
                font-size: 1.1rem;
                margin-bottom: 0;
            }
            .profile-card {
                background: white;
                border: none;
                border-radius: 12px;
                padding: 2rem;
                margin-top: 1rem;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
            }
            .profile-card:hover {
                transform: translateY(-5px);
            }
            .status-title {
                color: #3498db;
                font-weight: 600;
                margin-top: 1.5rem;
                border-bottom: 2px solid #3498db;
                padding-bottom: 0.5rem;
            }
            .status-item {
                font-size: 1.1rem;
                margin: 1rem 0;
                color: #34495e;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .status-count {
                font-weight: 700;
                color: #2ecc71;
                background: rgba(46, 204, 113, 0.1);
                padding: 0.3rem 1rem;
                border-radius: 20px;
            }
            .rejected {
                color: #e74c3c;
            }
            .rejected .status-count {
                background: rgba(231, 76, 60, 0.1);
            }
            .progress {
                height: 8px;
                margin-top: 0.5rem;
                background-color: #ecf0f1;
            }
            .progress-bar {
                background-color: #3498db;
            }
            .status-icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                margin-right: 1rem;
                background: rgba(52, 152, 219, 0.1);
            }
            .status-icon i {
                color: #3498db;
            }
            .status-content {
                flex: 1;
            }
            .status-row {
                display: flex;
                align-items: center;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="dashboard-container">
        <div class="container">
            <h1 class="title text-center">
                <i class="fas fa-chart-line mr-2"></i>Dashboard Monitoring Izin
            </h1>
            
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="summary-card">
                        <i class="fas fa-file-alt fa-2x text-primary"></i>
                        <div class="summary-number">{{ $jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak }}</div>
                        <p class="summary-label">Total Permohonan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                        <div class="summary-number">{{ $jumlahCetak }}</div>
                        <p class="summary-label">Izin Selesai</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                        <div class="summary-number">{{ $jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif }}</div>
                        <p class="summary-label">Dalam Proses</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="profile-card">
                        <h5 class="status-title"><i class="fas fa-spinner mr-2"></i>Izin Sedang Proses</h5>
                        
                        <div class="status-item">
                            <div class="status-row">
                                <div class="status-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="status-content">
                                    <div>Verifikasi Pendaftaran</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ ($jumlahPendaftaran / ($jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="status-count">{{ $jumlahPendaftaran }}</span>
                        </div>

                        <div class="status-item">
                            <div class="status-row">
                                <div class="status-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="status-content">
                                    <div>Verifikasi Kasi</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ ($jumlahKasiVerif / ($jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="status-count">{{ $jumlahKasiVerif }}</span>
                        </div>

                        <div class="status-item">
                            <div class="status-row">
                                <div class="status-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <div class="status-content">
                                    <div>Verifikasi Back Office</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ ($jumlahBackVerif / ($jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="status-count">{{ $jumlahBackVerif }}</span>
                        </div>

                        <h5 class="status-title"><i class="fas fa-check-circle mr-2"></i>Izin Selesai Diproses</h5>
                        <div class="status-item">
                            <div class="status-row">
                                <div class="status-icon">
                                    <i class="fas fa-file-signature"></i>
                                </div>
                                <div class="status-content">
                                    <div>Penyerahan Izin</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($jumlahCetak / ($jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="status-count">{{ $jumlahCetak }}</span>
                        </div>

                        <h5 class="status-title"><i class="fas fa-times-circle mr-2 rejected"></i>Izin Ditolak</h5>
                        <div class="status-item">
                            <div class="status-row">
                                <div class="status-icon rejected">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="status-content">
                                    <div>Penolakan</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($jumlahDitolak / ($jumlahPendaftaran + $jumlahKasiVerif + $jumlahBackVerif + $jumlahCetak + $jumlahDitolak)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="status-count rejected">{{ $jumlahDitolak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function updateDashboardStats() {
        fetch('/api/dashboard-stats', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update summary numbers
            document.querySelector('.summary-number:nth-child(2)').textContent = data.total;
            document.querySelector('.summary-number:nth-child(3)').textContent = data.selesai;
            document.querySelector('.summary-number:nth-child(4)').textContent = data.dalamProses;

            // Update status counts
            document.querySelectorAll('.status-count')[0].textContent = data.pendaftaran;
            document.querySelectorAll('.status-count')[1].textContent = data.kasiVerif;
            document.querySelectorAll('.status-count')[2].textContent = data.backVerif;
            document.querySelectorAll('.status-count')[3].textContent = data.cetak;
            document.querySelectorAll('.status-count')[4].textContent = data.ditolak;

            // Update progress bars
            const total = data.total;
            document.querySelectorAll('.progress-bar')[0].style.width = `${(data.pendaftaran / total) * 100}%`;
            document.querySelectorAll('.progress-bar')[1].style.width = `${(data.kasiVerif / total) * 100}%`;
            document.querySelectorAll('.progress-bar')[2].style.width = `${(data.backVerif / total) * 100}%`;
            document.querySelectorAll('.progress-bar')[3].style.width = `${(data.cetak / total) * 100}%`;
            document.querySelectorAll('.progress-bar')[4].style.width = `${(data.ditolak / total) * 100}%`;
        })
        .catch(error => console.error('Error updating dashboard stats:', error));
    }

    // Update stats every 5 seconds
    setInterval(updateDashboardStats, 5000);
    // Initial update
    updateDashboardStats();
</script>
@endsection
