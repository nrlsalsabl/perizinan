@extends('layouts.app')

@section('title', 'Tabel Referensi')

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
        <h1 class="mb-4">Tabel Referensi</h1>

        <form action="{{ route('tabel-referensi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_tabel">Nama Tabel</label>
                <input type="text" name="nama_tabel" id="nama_tabel" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>

        @if ($tabelReferensis->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tabel</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tabelReferensis as $index => $tabelReferensi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tabelReferensi->nama_tabel }}</td>
                            <td>
                                {{-- <a href="{{ route('tabel-referensi.kategori', $tabelReferensi->id) }}"
                                    class="btn btn-sm btn-secondary">Kategori</a> --}}
                                <form action="{{ route('tabel-referensi.destroy', $tabelReferensi->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
