@extends('layouts.app')

@section('title', 'Jenis Layanan')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-list-alt mr-2"></i>Daftar Jenis Layanan</h3>
            </div>
            
            <div class="card-body">
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="search" placeholder="Cari jenis layanan...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 100px">Aksi</th>
                                <th>Kode Jenis Layanan</th>
                                <th>Nama Jenis Layanan</th>
                                <th>Alias</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisLayanan as $layanan)
                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('jenis-layanan.edit', $layanan->id) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>{{ $layanan->kode_jenis_layanan }}</td>
                                    <td>{{ $layanan->nama_jenis_layanan }}</td>
                                    <td>{{ $layanan->alias }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        {{ $jenisLayanan->links() }}
                    </div>
                    <div>
                        <a href="{{ route('jenis-layanan.create') }}" class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>Tambah Jenis Layanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
