@extends('layouts.app')

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
            .page-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 2rem;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
            }
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
            .btn-submit {
                background: linear-gradient(135deg, #1e5799 0%,#207cca 100%);
                border: none;
                padding: 10px 25px;
                font-weight: 600;
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
            .btn-set {
                background: linear-gradient(135deg, #17a2b8 0%,#138496 100%);
                color: white;
                border: none;
                padding: 5px 15px;
                border-radius: 5px;
            }
            .btn-set:hover {
                opacity: 0.9;
            }
            .form-control {
                border-radius: 5px;
                padding: 10px 15px;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="page-title">
            <i class="fas fa-tasks mr-2"></i>Manajemen Permohonan Izin
        </h1>
        
        <div class="card card-filter shadow">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Pencarian</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('release-permohonan.search') }}">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_izin_id" class="font-weight-bold">Jenis Izin</label>
                                <select class="form-control select2" name="jenis_izin_id" id="jenis_izin_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($jenisIzins as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_izin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_layanan" class="font-weight-bold">Jenis Layanan</label>
                                <select class="form-control select2" name="jenis_layanan" id="jenis_layanan">
                                    <option value="">- Pilih -</option>
                                    @foreach ($jenisLayanans as $layanan)
                                        <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search" class="font-weight-bold">Cari Nama Pemohon</label>
                                <input type="text" class="form-control" name="search" id="search" placeholder="Masukkan nama pemohon">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-submit text-white mr-2">
                                <i class="fas fa-search mr-2"></i>Proses
                            </button>
                            <a href="{{ route('release-permohonan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-sync-alt mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($dataPermohonan->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Resi</th>
                            <th>Nama Pemohon</th>
                            <th>Jenis Izin</th>
                            <th>Jenis Proses</th>
                            <th>Proses Terakhir</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPermohonan as $index => $permohonan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <button class="btn btn-set" data-toggle="modal"
                                        data-target="#releaseModal{{ $permohonan->id }}">
                                        <i class="fas fa-cog mr-1"></i>Set
                                    </button>
                                </td>
                                <td>{{ $permohonan->resi }}</td>
                                <td>{{ $permohonan->nama_pemohon }}</td>
                                <td>{{ $permohonan->jenis_izin }}</td>
                                <td>{{ $permohonan->jenis_permohonan }}</td>
                                <td>{{ $permohonan->proses_terakhir }}</td>
                                <td>{{ $permohonan->role }}</td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="releaseModal{{ $permohonan->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="releaseModalLabel{{ $permohonan->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Manajemen Permohonan Izin</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('release-permohonan.update', $permohonan->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Kembalikan Berkas ke Proses</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="proses" id="pendaftaran" value="pendaftaran">
                                                        <label class="form-check-label" for="pendaftaran">Pendaftaran</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="proses" id="verifikasi_pendaftaran" value="verifikasi_pendaftaran">
                                                        <label class="form-check-label" for="verifikasi_pendaftaran">Verifikasi Pendaftaran</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="proses" id="verifikasi_lokasi" value="verifikasi_lokasi">
                                                        <label class="form-check-label" for="verifikasi_lokasi">Verifikasi Lokasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="proses" id="proses" value="proses">
                                                        <label class="form-check-label" for="proses">Proses</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="proses" id="penolakan" value="penolakan">
                                                        <label class="form-check-label" for="penolakan">Penolakan</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="catatan" class="font-weight-bold">Catatan</label>
                                                    <textarea class="form-control" name="catatan" rows="3" placeholder="Masukkan catatan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-2"></i>Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save mr-2"></i>Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>Tidak ada data permohonan ditemukan.
            </div>
        @endif
    </div>
@endsection
