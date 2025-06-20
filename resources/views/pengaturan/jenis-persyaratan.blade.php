@extends('layouts.app')

@section('title', 'Jenis Persyaratan')

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
                <h3 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i>Daftar Jenis Persyaratan Perijinan</h3>
            </div>
            
            <div class="card-body">
                <form action="{{ route('jenis-persyaratan.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control" placeholder="Cari jenis persyaratan...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i>Search
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 120px">Aksi</th>
                                <th>Nama Persyaratan</th>
                                <th>Nama Nomor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisPersyaratan as $persyaratan)
                                <tr>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('jenis-persyaratan.edit', $persyaratan->id) }}"
                                                class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('jenis-persyaratan.destroy', $persyaratan->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>{{ $persyaratan->nama_persyaratan }}</td>
                                    <td>{{ $persyaratan->nama_nomor }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        {{ $jenisPersyaratan->links() }}
                    </div>
                    <div>
                        <a href="{{ route('jenis-persyaratan.create') }}" class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>Tambah Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
