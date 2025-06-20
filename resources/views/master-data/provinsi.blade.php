@extends('layouts.app')

@section('title', 'Provinsi')

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
        <h1 class="mb-4">Provinsi</h1>
        <a href="{{ route('provinsi.create') }}" class="btn btn-primary mb-4">Tambah Data</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Singkatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($provinsi as $provinsis)
                    <tr>
                        <td>
                            <a href="{{ route('provinsi.edit', $provinsis->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('provinsi.destroy', $provinsis->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                        <td>{{ $provinsis->kode }}</td>
                        <td>{{ $provinsis->nama }}</td>
                        <td>{{ $provinsis->singkatan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
