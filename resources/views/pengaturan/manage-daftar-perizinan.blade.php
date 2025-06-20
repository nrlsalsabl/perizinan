@extends('layouts.app')

@section('title', 'Kelola Perizinan')

@section('head')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kelola Perizinan')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kelola Data Perizinan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('daftar-perizinan.update', $perizinan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" value="{{ $perizinan->kode }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_jenis_perizinan">Nama Jenis Perizinan</label>
                            <input type="text" class="form-control" id="nama_jenis_perizinan" name="nama_jenis_perizinan" value="{{ $perizinan->nama_jenis_perizinan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="masa_berlaku">Masa Berlaku</label>
                            <input type="text" class="form-control" id="masa_berlaku" name="masa_berlaku" value="{{ $perizinan->masa_berlaku }}">
                        </div>

                        <div class="form-group">
                            <label for="retribusi">Retribusi</label>
                            <input type="text" class="form-control" id="retribusi" name="retribusi" value="{{ $perizinan->retribusi }}">
                        </div>

                        <div class="form-group">
                            <label for="po">PO</label>
                            <input type="text" class="form-control" id="po" name="po" value="{{ $perizinan->po }}">
                        </div>

                        <div class="form-group">
                            <label for="bu">BU</label>
                            <input type="text" class="form-control" id="bu" name="bu" value="{{ $perizinan->bu }}">
                        </div>

                        <div class="form-group">
                            <label for="sop">SOP</label>
                            <input type="text" class="form-control" id="sop" name="sop" value="{{ $perizinan->sop }}">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Aktif" {{ $perizinan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ $perizinan->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="online">Online</label>
                            <select class="form-control" id="online" name="online">
                                <option value="1" {{ $perizinan->online ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$perizinan->online ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="format_no_izin">Format No Izin</label>
                            <input type="text" class="form-control" id="format_no_izin" name="format_no_izin" value="{{ $perizinan->format_no_izin }}">
                        </div>

                        <div class="form-group">
                            <label for="dinas_badan">Dinas/Badan</label>
                            <input type="text" class="form-control" id="dinas_badan" name="dinas_badan" value="{{ $perizinan->dinas_badan }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('daftar-perizinan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
