@extends('layouts.app')

@section('title', 'Informasi Perizinan')

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
                <h3 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Informasi Perizinan</h3>
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form action="{{ route('informasi-perizinan.index') }}" method="GET" class="w-75">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="Cari informasi perizinan...">
                        </div>
                    </form>
                    <a href="{{ route('informasi-perizinan.create') }}" class="btn btn-success">
                        <i class="fas fa-plus mr-2"></i>Tambah Data
                    </a>
                </div>

                @if ($informasiPerizinan->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="150px" class="text-center">Aksi</th>
                                    <th>Jenis Izin</th>
                                    <th>Informasi Izin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informasiPerizinan as $info)
                                    <tr>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('informasi-perizinan.edit', $info->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('informasi-perizinan.destroy', $info->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>{{ $info->jenis_izin }}</td>
                                        <td>{{ $info->informasi_izin }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $informasiPerizinan->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>Tidak ada data informasi perizinan yang ditemukan.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
