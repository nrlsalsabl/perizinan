@extends('layouts.app')

@section('title', 'Jenis Layanan Terhadap Izin')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-cog mr-2"></i>Setting Jenis Layanan Menurut Jenis Izin</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('jenis-layanan-izin.index') }}" method="GET" id="searchForm" class="mb-4">
                    <div class="form-group">
                        <label for="jenis_izin" class="font-weight-bold">Pilih Jenis Izin</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                            </div>
                            <select name="jenis_izin" id="jenis_izin" class="form-control select2" onchange="document.getElementById('searchForm').submit();">
                                <option value="">-- Pilih Jenis Izin --</option>
                                @foreach ($jenisIzin as $izin)
                                    <option value="{{ $izin->id }}" {{ $selectedJenisIzin == $izin->id ? 'selected' : '' }}>
                                        {{ $izin->nama_jenis_izin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                @if($jenisLayanan->count() > 0)
                    <form action="{{ route('jenis-layanan-izin.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="50px" class="text-center">Pilih</th>
                                        <th>Nama Layanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jenisLayanan as $layanan)
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="layanan_ids[]" value="{{ $layanan->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $layanan->nama_jenis_layanan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>Tidak ada data layanan yang tersedia.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Jenis Izin",
                allowClear: true
            });

            document.getElementById('checkAll').onclick = function() {
                var checkboxes = document.getElementsByName('layanan_ids[]');
                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            }
        });
    </script>
@endsection
