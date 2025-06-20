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
        <h1>Edit Role</h1>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $role->name }}"
                    required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" class="form-control" id="description"
                    value="{{ $role->description }}" required>
            </div>

            <div class="form-group">
                <label for="daftar_akses">Daftar Akses</label>
                <textarea name="daftar_akses" class="form-control" id="daftar_akses" rows="4" required>{{ $role->daftar_akses }}</textarea>
            </div>

            <div class="form-group">
                <label for="proses_izin">Proses Izin</label>
                <input type="text" name="proses_izin" class="form-control" id="proses_izin"
                    value="{{ $role->proses_izin }}">
            </div>

            <div class="form-group">
                <label for="use_pin">Use PIN?</label>
                <select name="use_pin" class="form-control" id="use_pin">
                    <option value="1" {{ $role->use_pin ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ !$role->use_pin ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
