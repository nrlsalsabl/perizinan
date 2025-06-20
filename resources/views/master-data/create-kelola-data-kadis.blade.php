@extends('layouts.app')

@section('title', 'Tambah Data Kadis')

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        
        <style>
            .preview-image {
                max-width: 200px;
                max-height: 200px;
                margin-top: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 5px;
            }
            .card-header {
                border-bottom: 2px solid rgba(0,0,0,.125);
            }
            .form-control {
                border-radius: 0.25rem;
            }
            .btn-submit {
                border-radius: 0.25rem;
                padding: 0.5rem 1.5rem;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user-plus mr-2"></i>Tambah Data Kadis</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('kelola-data-kadis.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="form-group">
                        <label for="nip" class="font-weight-bold">NIP <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="number" name="nip" class="form-control" id="nip" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama" class="font-weight-bold">Nama <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="nama" class="form-control" id="nama" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pangkat" class="font-weight-bold">Pangkat <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-star"></i></span>
                            </div>
                            <input type="text" name="pangkat" class="form-control" id="pangkat" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="periode" class="font-weight-bold">Periode <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" name="periode" id="periode" class="form-control date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Status <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                            </div>
                            <select name="status" class="form-control" id="status">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif" selected>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ttd" class="font-weight-bold">TTD Digital</label>
                        <div class="custom-file">
                            <input type="file" name="ttd" class="custom-file-input" id="ttd" accept="image/*">
                            <label class="custom-file-label" for="ttd">Pilih file...</label>
                        </div>
                        <img id="preview" class="preview-image mt-2" style="display: none;">
                        @error('ttd')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                multidate: true, // Mengaktifkan pemilihan banyak tanggal
                format: 'dd-mm-yyyy', // Format tanggal
                todayHighlight: true, // Menyorot tanggal hari ini
                clearBtn: true // Menambahkan tombol untuk menghapus tanggal
                // multidateSeparator: '-' // Ubah separator menjadi '-'
            });

            // Initialize Select2
            $('.select2').select2({
                placeholder: '-- Pilih Jenis Izin --',
                allowClear: true
            });

            // Preview image before upload
            $('#ttd').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var multiSelect = document.querySelector('#ms1');
            if (multiSelect) {
                new coreui.MultiSelect(multiSelect);
            }
        });
    </script> --}}
@endsection
