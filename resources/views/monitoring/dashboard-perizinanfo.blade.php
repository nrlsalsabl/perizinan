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
                <i class="fas fa-chart-line mr-2"></i>Detail Status Perizinan
            </h1>

<div class="table-responsive">
    <table class="table table-bordered bg-white mt-3">
        <thead class="thead-light">
            <tr>
                <th>Resi</th>
                <th>Nama Pemohon</th>
                <th>Jenis Izin</th>
                <th>Front Office</th>
                <th>Kasi</th>
                <th>Back Office</th>
                <th>Cetak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $izin)
                <tr>
                    <td>{{ $izin->resi }}</td>
                    <td>{{ $izin->nama_pemohon }}</td>
                    <td>{{ $izin->jenis_izin }}</td>
                    <td>@include('components.status-badge', ['status' => $izin->fo_status])</td>
                    <td>@include('components.status-badge', ['status' => $izin->kasi_status])</td>
                    <td>@include('components.status-badge', ['status' => $izin->bo_status])</td>
                    <td>@include('components.status-badge', ['status' => $izin->cetak_status])</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection