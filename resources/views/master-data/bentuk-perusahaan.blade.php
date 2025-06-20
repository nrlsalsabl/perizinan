@extends('layouts.app')

@section('title', 'Bentuk Perusahaan')

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
                <h3 class="mb-0"><i class="fas fa-building mr-2"></i>Daftar Bentuk Perusahaan</h3>
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('bentuk-perusahaan.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-2"></i>Tambah Data
                    </a>
                    
                    <form action="{{ route('bentuk-perusahaan.index') }}" method="GET" class="w-50">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="Cari bentuk perusahaan...">
                        </div>
                    </form>
                </div>

                @if ($bentukPerusahaan->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50px" class="text-center">No</th>
                                    <th>Bentuk Perusahaan</th>
                                    <th>Singkatan</th>
                                    <th width="150px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bentukPerusahaan as $index => $perusahaan)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $perusahaan->bentuk_perusahaan }}</td>
                                        <td>{{ $perusahaan->singkatan }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('bentuk-perusahaan.edit', $perusahaan->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('bentuk-perusahaan.destroy', $perusahaan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>Tidak ada data bentuk perusahaan.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
