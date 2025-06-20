@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi Izin')

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

        <style>
            .card-filter {
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                margin-bottom: 2rem;
            }
            .card-header {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                color: white;
                border-radius: 10px 10px 0 0 !important;
            }
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .table thead {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                color: white;
            }
            .btn-submit {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                border: none;
                padding: 10px 25px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }
            .form-control {
                border-radius: 5px;
                padding: 10px 15px;
            }
            .select2-container--default .select2-selection--single {
                height: 38px;
                border-radius: 5px;
                padding: 5px;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card card-filter shadow">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Laporan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('monitoring.rekapitulasi.process') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_awal" class="font-weight-bold">Tanggal Awal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_akhir" class="font-weight-bold">Tanggal Akhir</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_izin" class="font-weight-bold">Jenis Izin</label>
                                <select name="jenis_izin" id="jenis_izin" class="form-control select2">
                                    <option value="">-Semua-</option>
                                    @foreach ($jenisIzins as $data)
                                        <option value="{{ $data->nama_jenis_izin }}">{{ $data->nama_jenis_izin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-submit text-white">
                            <i class="fas fa-search mr-2"></i>Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (isset($dataIzin) && $dataIzin->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Resi</th>
                            <th>Pemohon</th>
                            <th>Jenis Perizinan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataIzin as $index => $izin)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $izin->resi }}</td>
                                <td>{{ $izin->nama_pemohon }}</td>
                                <td>{{ $izin->jenis_izin }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle mr-2"></i>Tidak ada data izin yang ditemukan untuk rentang tanggal dan jenis izin yang dipilih.
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Jenis Izin",
                allowClear: true
            });
        });
    </script>
@endsection
