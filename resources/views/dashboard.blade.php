@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <style>
            :root {
                --primary: #4361ee;
                --secondary: #3f37c9;
                --accent: #f72585;
                --light: #f8f9fa;
                --dark: #212529;
            }
            
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
            }
            
            .welcome-container {
                max-width: 700px;
                margin: 40px auto;
                padding: 40px;
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
                animation: fadeInUp 0.8s ease;
            }
            
            .welcome-title {
                color: var(--secondary);
                font-weight: 700;
                margin-bottom: 10px;
                font-size: 2.5rem;
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .welcome-subtitle {
                color: #6c757d;
                margin-bottom: 30px;
                font-size: 1.2rem;
            }
            
            .date-btn {
                background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
                border: none;
                padding: 12px 30px;
                border-radius: 50px;
                font-weight: 600;
                margin-bottom: 30px;
                box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
                color: white;
                transition: all 0.3s ease;
                font-size: 1.1rem;
            }
            
            .date-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
            }
            
            .profile-card {
                background: white;
                border: none;
                border-radius: 15px;
                padding: 30px;
                margin-top: 30px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.08);
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,249,250,0.9) 100%);
            }
            
            .profile-card:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            }
            
            .profile-title {
                color: var(--secondary);
                font-weight: 700;
                margin-bottom: 25px;
                position: relative;
                font-size: 1.5rem;
            }
            
            .profile-title:after {
                content: '';
                display: block;
                width: 80px;
                height: 4px;
                background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
                margin: 15px auto;
                border-radius: 2px;
            }
            
            .profile-detail {
                margin-bottom: 15px;
                color: #495057;
                font-size: 1.1rem;
                padding: 8px 0;
                border-bottom: 1px dashed #e9ecef;
            }
            
            .profile-detail strong {
                color: var(--dark);
                width: 150px;
                display: inline-block;
                font-weight: 600;
            }
            
            .btn-edit {
                background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
                color: white;
                border: none;
                border-radius: 50px;
                padding: 10px 25px;
                font-weight: 600;
                margin-top: 20px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(250, 208, 196, 0.4);
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.9rem;
            }
            
            .btn-edit:hover {
                background: linear-gradient(135deg, #fad0c4 0%, #ff9a9e 100%);
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 8px 20px rgba(250, 208, 196, 0.6);
                color: white;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="d-flex justify-content-center animate__animated animate__fadeIn">
        <div class="welcome-container text-center">
            <h1 class="welcome-title animate__animated animate__fadeInDown">Selamat datang,</h1>
            <p class="welcome-subtitle animate__animated animate__fadeIn animate__delay-1s">di Aplikasi Sistem Perizinan</p>
            
            <button class="date-btn animate__animated animate__pulse animate__delay-2s">
                <i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::now()->format('d M Y') }}
            </button>

            <div class="profile-card animate__animated animate__fadeInUp animate__delay-1s">
                <h5 class="profile-title text-center">Profil Pengguna</h5>
                <p class="profile-detail"><strong><i class="fas fa-user me-2"></i> Nama:</strong> {{ Auth::user()->name }}</p>
                <p class="profile-detail"><strong><i class="fas fa-map-marker-alt me-2"></i> Alamat:</strong> {{ Auth::user()->alamat }}</p>
                <p class="profile-detail"><strong><i class="fas fa-envelope me-2"></i> Email:</strong> {{ Auth::user()->email }}</p>
                <p class="profile-detail"><strong><i class="fas fa-phone me-2"></i> No. Telp:</strong> {{ Auth::user()->phone }}</p>
                <p class="profile-detail"><strong><i class="fas fa-briefcase me-2"></i> Jabatan:</strong> {{ Auth::user()->jabatan }}</p>
                
                <div class="text-center">
                    @if (Auth::user()->jabatan == 'front end')
                        <a href="{{ route('edit-user.registrasi', Auth::user()->id) }}" class="btn btn-edit">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil
                        </a>
                    @else
                        <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-edit">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
