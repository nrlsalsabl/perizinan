@extends('layouts.app')

@section('title', 'Account Pemohon')

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
        <h1 class="mb-4">Data Account Pemohon</h1>

        <div class="mb-4">
            <input type="text" class="form-control" id="search" placeholder="Search">
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Identitas (NIK)</th>
                    <th>Pemohon</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Last Login</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountPemohon as $index => $pemohon)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pemohon->nik }}</td>
                        <td>{{ $pemohon->name }}</td>
                        <td>{{ $pemohon->alamat }}</td>
                        <td>{{ $pemohon->telepon }}</td>
                        <td>{{ $pemohon->last_login }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <!-- Pagination -->
                {{ $accountPemohon->links() }}
            </div>
            <div>
                <button class="btn btn-success">Tambah Account Pemohon</button>
            </div>
        </div>
    </div>
@endsection
