@extends('layouts.app')

@section('head')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>


    </head>
@endsection

@section('content')
    <div class="container">
        <h1>Daftar Survey Pertanyaan</h1>

        <!-- Tombol Tambah Pertanyaan -->
        <a href="{{ route('skm.tambah-pertanyaan') }}" class="btn btn-primary mb-3">+ Tambah Pertanyaan</a>

        <!-- Pencarian Pertanyaan -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('skm.daftar-pertanyaan') }}">
                    <input type="text" name="search" class="form-control" placeholder="Pencarian pertanyaan..."
                        value="{{ request('search') }}">
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Pertanyaan -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Act</th>
                    <th>Pertanyaan</th>
                    <th>Pilihan Jawaban</th>
                    <th>Bobot Nilai</th>
                    <th>Status Pertanyaan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pertanyaan as $index => $q)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <!-- Tombol Edit dan Delete -->
                            <a href="{{ route('skm.edit-pertanyaan', $q->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('skm.delete-pertanyaan', $q->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $q->pertanyaan }}</td>
                        <td>
                            <ul>
                                @foreach ($q->jawaban as $jawaban)
                                    <li>{{ $jawaban->pilihan_jawaban }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach ($q->jawaban as $jawaban)
                                    <li>{{ $jawaban->bobot_nilai }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $q->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
