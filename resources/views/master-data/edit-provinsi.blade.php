@extends('layouts.app')

@section('title', 'Edit Provinsi')

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
    <div class="container mt-4">
        <h1 class="mb-4">Edit Provinsi</h1>

        <form action="{{ route('provinsi.update', $provinsi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="kode">Kode</label>
                <input type="text" name="kode" id="kode" class="form-control" value="{{ $provinsi->kode }}"
                    required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $provinsi->nama }}"
                    required>
            </div>
            <div class="form-group">
                <label for="singkatan">Singkatan</label>
                <input type="text" name="singkatan" id="singkatan" class="form-control"
                    value="{{ $provinsi->singkatan }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
