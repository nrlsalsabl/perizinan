@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Tambah Jenis Layanan')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    </head>
@endsection

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Tambah Jenis Layanan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('jenis-layanan.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="form-group">
                        <label for="kode" class="font-weight-bold">Kode Jenis Layanan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-code"></i></span>
                            </div>
                            <input type="text" name="kode_jenis_layanan" class="form-control" id="kode" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_jenis" class="font-weight-bold">Nama Jenis Layanan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                            </div>
                            <input type="text" name="nama_jenis_layanan" class="form-control" id="nama_jenis" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alias" class="font-weight-bold">Alias</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                            <input type="text" name="alias" class="form-control" id="alias">
                        </div>
                    </div>

                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
