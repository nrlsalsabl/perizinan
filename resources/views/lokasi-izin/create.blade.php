@extends('layouts.app')

@section('title', 'Lokasi Izin')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
        <style>
            .form-container {
                background: white;
                padding: 2.5rem;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                max-width: 800px;
                margin: 0 auto;
            }
            .form-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 2rem;
                text-align: center;
                position: relative;
                padding-bottom: 10px;
            }
            .form-title::after {
                content: '';
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                bottom: 0;
                width: 80px;
                height: 3px;
                background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
            }
            .form-control {
                border-radius: 8px;
                padding: 12px 15px;
                border: 1px solid #ddd;
                transition: all 0.3s;
            }
            .form-control:focus {
                border-color: #3498db;
                box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            }
            .btn-action {
                padding: 10px 25px;
                font-weight: 600;
                border-radius: 8px;
                transition: all 0.3s;
            }
            .btn-next {
                background: linear-gradient(135deg, #28a745 0%, #218838 100%);
                border: none;
                color: white;
            }
            .btn-next:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            }
            .btn-back {
                background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
                border: none;
                color: white;
            }
            .error-message {
                color: #e74c3c;
                font-size: 0.9rem;
                margin-top: 5px;
            }
            .input-group-text {
                background-color: #f8f9fa;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container py-4">
        <div class="form-container">
            <h1 class="form-title">
                <i class="fas fa-map-marked-alt mr-2"></i>Lokasi Izin
            </h1>
            <form action="{{ route('lokasi-izin.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="jalan" class="font-weight-bold">
                            <i class="fas fa-road mr-2"></i>Jalan
                        </label>
                        <input type="text" id="jalan" name="jalan" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nomor" class="font-weight-bold">
                            <i class="fas fa-hashtag mr-2"></i>No.
                        </label>
                        <input type="text" id="nomor" name="nomor" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="rt" class="font-weight-bold">
                            <i class="fas fa-home mr-2"></i>RT
                        </label>
                        <input type="text" id="rt" name="rt" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rw" class="font-weight-bold">
                            <i class="fas fa-city mr-2"></i>RW
                        </label>
                        <input type="text" id="rw" name="rw" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="provinsi" class="font-weight-bold">
                            <i class="fas fa-map mr-2"></i>Provinsi
                        </label>
                        <select class="form-control form-control-lg select2" id="provinsi" name="provinsi"></select>
                        @error('provinsi')
                            <div class="error-message">{!! $message !!}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="kabupaten" class="font-weight-bold">
                            <i class="fas fa-map-marked mr-2"></i>Kabupaten
                        </label>
                        <select class="form-control form-control-lg select2" id="kabupaten" name="kabupaten"></select>
                        @error('kabupaten')
                            <div class="error-message">{!! $message !!}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="kecamatan" class="font-weight-bold">
                            <i class="fas fa-map-pin mr-2"></i>Kecamatan
                        </label>
                        <select class="form-control form-control-lg select2" id="kecamatan" name="kecamatan"></select>
                        @error('kecamatan')
                            <div class="error-message">{!! $message !!}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('data-perusahaan.show') }}" class="btn btn-action btn-back">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-action btn-next">
                            Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            console.log('mulai');
            // Load data ke select singkatan
            const get_subprovinsi2 = () => {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subprovinsi2') }}",
                    type: 'GET',
                    success: function(json) {
                        // Clear select options
                        $('#provinsi').empty();
                        // Tambahkan opsi default
                        $('#provinsi').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item
                                .nama);
                            $('#provinsi').append(new Option(item.nama, item.id));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

            const get_subkabupaten = () => {
                const idProvinsi = $('#provinsi').val();
                if (!idProvinsi) return;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subkabupaten') }}",
                    type: 'GET',
                    data: {
                        provinsi: idProvinsi
                    },
                    success: function(json) {
                        // Clear select options
                        $('#kabupaten').empty();
                        // Tambahkan opsi default
                        $('#kabupaten').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item.nama);
                            $('#kabupaten').append(new Option(item.nama, item.id));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

            const get_subkecamatan = () => {
                const idKabupaten = $('#kabupaten').val();
                if (!idKabupaten) return;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subkecamatan') }}",
                    type: 'GET',
                    data: {
                        kabupaten_kota: idKabupaten
                    },
                    success: function(json) {
                        // Clear select options
                        $('#kecamatan').empty();
                        // Tambahkan opsi default
                        $('#kecamatan').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item.nama);
                            $('#kecamatan').append(new Option(item.nama, item.id));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

            // Panggil fungsi saat ada perubahan pada <select>
            $('#provinsi').on('change', function() {
                get_subkabupaten();
            });

            // Panggil fungsi saat ada perubahan pada <select>
            $('#kabupaten').on('change', function() {
                get_subkecamatan();
            });

            // Panggil fungsi untuk memuat data awal
            get_subprovinsi2();
        });
    </script>
@endsection
