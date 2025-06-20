@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Tambah Perizinan')</title>
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
                <h3 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Tambah Daftar Perizinan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('daftar-perizinan.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_jenis_perizinan" class="font-weight-bold">Nama Jenis Perizinan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                    </div>
                                    <select name="nama_jenis_perizinan" class="form-control select2" id="nama_jenis_perizinan" required>
                                        <option value="">Pilih Jenis Perizinan</option>
                                        @foreach($jenisIzins as $jenisIzin)
                                            <option value="{{ $jenisIzin->id }}">{{ $jenisIzin->nama_jenis_izin }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="form-text text-muted">
                                    Semua field lainnya akan di-generate secara otomatis berdasarkan jenis perizinan yang dipilih.
                                </small>
                            </div>
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

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Jenis Perizinan",
                allowClear: true
            });
        });
    </script>
@endsection
