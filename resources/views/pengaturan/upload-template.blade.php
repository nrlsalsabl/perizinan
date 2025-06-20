@extends('layouts.app')

@section('title', 'Upload Template Izin')

@section('head')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>


    </head>
@endsection


@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Template Surat Izin: {{ $jenisIzin->nama_izin }}</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Upload File
                    </div>
                    <div class="card-body">
                        <form action="{{ route('upload.template', $jenisIzin->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="keterangan_file">Keterangan File</label>
                                <input type="text" name="keterangan_file" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" name="file" class="form-control" required>
                                <small class="form-text text-muted">File harus bertipe .docx.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        File Template Yang Sudah Diupload
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Keterangan File</th>
                                    <th>Status Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $template)
                                    <tr>
                                        <td>{{ $template->nama_layanan }}</td>
                                        <td>Sedang Aktif Sekarang</td>
                                        <td>
                                            <a href="{{ asset('uploads/templates/' . $template->template_surat) }}"
                                                target="_blank">{{ $template->template_surat }}</a> |
                                            <form action="{{ route('delete.template', $template->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
