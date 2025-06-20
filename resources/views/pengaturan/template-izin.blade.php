@extends('layouts.app')

@section('title', 'Template Izin')

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
                <h3 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Template Izin</h3>
            </div>
            
            <div class="card-body">
                <form action="{{ route('template-izin.index') }}" method="GET" class="mb-4">
                    <div class="form-group">
                        <label for="jenis_izin" class="font-weight-bold">Pilih Jenis Izin</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                            </div>
                            <select name="jenis_izin" id="jenis_izin" class="form-control select2" onchange="this.form.submit()">
                                <option value="">-- Pilih Jenis Izin --</option>
                                @foreach ($jenisIzins as $izin)
                                    <option value="{{ $izin->id }}"
                                        {{ isset($selectedJenisIzin) && $selectedJenisIzin == $izin->id ? 'selected' : '' }}>
                                        {{ $izin->nama_jenis_izin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50px">No</th>
                                <th>Nama Layanan</th>
                                <th>Template Cetak Izin</th>
                                <th width="200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisLayanan as $index => $jenisLayanans)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $jenisLayanans->nama_jenis_layanan }}</td>
                                    <td>
                                        @php
                                            $filteredTemplates = $templateIzins->where('nama_layanan', $jenisLayanans->nama_jenis_layanan);
                                        @endphp

                                        @foreach ($filteredTemplates as $templateIzin)
                                            <div class="mb-2">
                                                <span class="font-weight-bold">Template Surat:</span>
                                                @if ($templateIzin->template_surat)
                                                    <a href="{{ asset('storage/' . $templateIzin->template_surat) }}" target="_blank"
                                                        class="btn btn-sm btn-success ml-2">
                                                        <i class="fas fa-download mr-1"></i>Download
                                                    </a>
                                                    <a href="{{ route('template-izin.preview', ['id' => $templateIzin->id, 'type' => 'surat']) }}" target="_blank"
                                                        class="btn btn-sm btn-info ml-2">
                                                        <i class="fas fa-eye mr-1"></i>Preview
                                                    </a>
                                                    <form action="{{ route('template-izin.delete', ['id' => $templateIzin->id, 'type' => 'surat']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus template surat ini?')">
                                                            <i class="fas fa-trash mr-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted ml-2">Belum Diunggah</span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-weight-bold">Template Teknis:</span>
                                                @if ($templateIzin->template_teknis)
                                                    <a href="{{ asset('storage/' . $templateIzin->template_teknis) }}" target="_blank"
                                                        class="btn btn-sm btn-info ml-2">
                                                        <i class="fas fa-download mr-1"></i>Download
                                                    </a>
                                                    <a href="{{ route('template-izin.preview', ['id' => $templateIzin->id, 'type' => 'teknis']) }}" target="_blank"
                                                        class="btn btn-sm btn-info ml-2">
                                                        <i class="fas fa-eye mr-1"></i>Preview
                                                    </a>
                                                    <form action="{{ route('template-izin.delete', ['id' => $templateIzin->id, 'type' => 'teknis']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus template teknis ini?')">
                                                            <i class="fas fa-trash mr-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted ml-2">Belum Diunggah</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (!empty($selectedJenisIzin))
                                            <form action="{{ route('template-izin.upload', ['id' => $selectedJenisIzin]) }}"
                                                method="POST" enctype="multipart/form-data" class="mb-2">
                                                @csrf
                                                <div class="input-group">
                                                    <div class="custom-file" style="width: 200px;">
                                                        <input type="file" name="template_surat" class="custom-file-input" id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">Pilih file surat</label>
                                                    </div>
                                                    <input type="hidden" name="nama_layanan" value="{{ $jenisLayanans->nama_jenis_layanan }}">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-upload mr-1"></i>Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <form action="{{ route('template-izin.upload', ['id' => $selectedJenisIzin]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group">
                                                    <div class="custom-file" style="width: 200px;">
                                                        <input type="file" name="template_teknis" class="custom-file-input" id="inputGroupFile02">
                                                        <label class="custom-file-label" for="inputGroupFile02" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">Pilih file teknis</label>
                                                    </div>
                                                    <input type="hidden" name="nama_layanan" value="{{ $jenisLayanans->nama_jenis_layanan }}">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-upload mr-1"></i>Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0"><i class="fas fa-list mr-2"></i>Daftar Variabel</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50px">No</th>
                                        <th>Caption</th>
                                        <th>Normal Variable</th>
                                        <th>Uppercase Variable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variables as $index => $variable)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $variable->caption }}</td>
                                            <td><code>{{ $variable->normal_variable }}</code></td>
                                            <td><code>{{ $variable->uppercase_variable }}</code></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endsection
