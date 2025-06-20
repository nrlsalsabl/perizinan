@extends('layouts.app')

@section('title', 'Pengajuan Permohonan')

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
            }
            .form-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 2rem;
                position: relative;
                padding-bottom: 10px;
            }
            .form-title::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: 0;
                width: 50px;
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
            .btn-submit {
                background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
                border: none;
                padding: 10px 25px;
                font-weight: 600;
                border-radius: 8px;
                transition: all 0.3s;
            }
            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(30, 87, 153, 0.3);
            }
            .error-message {
                color: #e74c3c;
                font-size: 0.9rem;
                margin-top: 5px;
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container py-4">
        <div class="form-container">
            <h1 class="form-title">
                <i class="fas fa-file-alt mr-2"></i>Pengajuan Permohonan
            </h1>
            <form action="{{ route('pengajuan-permohonan.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="dinas_badan" class="font-weight-bold">
                        <i class="fas fa-building mr-2"></i>Dinas/Badan
                    </label>
                    <input class="form-control" type="text" name="dinas_badan" id="dinas_badan" placeholder="Masukkan Nama Dinas/Badan">
                    @error('dinas_badan')
                        <div class="error-message">{!! $message !!}</div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="jenis_izin" class="font-weight-bold">
                        <i class="fas fa-file-signature mr-2"></i>Jenis Izin
                    </label>
                    <select class="form-control form-control-lg select2" id="jenis_izin" name="jenis_izin" style="width: 100%"></select>
                    @error('jenis_izin')
                        <div class="error-message">{!! $message !!}</div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="jenis_permohonan" class="font-weight-bold">
                        <i class="fas fa-tasks mr-2"></i>Jenis Permohonan
                    </label>
                    <select class="form-control form-control-lg" id="jenis_permohonan" name="jenis_permohonan">
                        <option value="" selected>Pilih Jenis Permohonan</option>
                        <option value="Perizinan Baru">Perizinan Baru</option>
                        <option value="Perpanjang Perizinan">Perpanjang Perizinan</option>
                    </select>
                    @error('jenis_permohonan')
                        <div class="error-message">{!! $message !!}</div>
                    @enderror
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-submit text-white">
                        <i class="fas fa-paper-plane mr-2"></i>Proses
                    </button>
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
            const get_jenisizin = () => {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('pengajuan-permohonan.get_jenisizin') }}",
                    type: 'GET',
                    success: function(json) {
                        // Clear select options
                        $('#jenis_izin').empty();
                        // Tambahkan opsi default
                        $('#jenis_izin').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item
                                .nama_jenis_izin);
                            $('#jenis_izin').append(new Option(item.nama_jenis_izin, item
                                .nama_jenis_izin));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

            // const get_subkabupaten = () => {
            //     const idProvinsi = $('#provinsi').val();
            //     if (!idProvinsi) return;

            //     $.ajax({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         url: "{{ route('kecamatan.get_subkabupaten') }}",
            //         type: 'GET',
            //         data: {
            //             provinsi: idProvinsi
            //         },
            //         success: function(json) {
            //             // Clear select options
            //             $('#kabupaten_kota').empty();
            //             // Tambahkan opsi default
            //             $('#kabupaten_kota').append(new Option("-- No Parent --", ""));
            //             // Tambahkan opsi dari data
            //             $.each(json.data, function(i, item) {
            //                 console.log('item.id: ', item.id, 'name', item.nama);
            //                 $('#kabupaten_kota').append(new Option(item.nama, item.id));
            //             });
            //             console.log('Data diterima:', json);
            //         },
            //         error: function(error) {
            //             console.error('Error fetching subprovinsi:', error);
            //         },
            //     });
            // };

            // Load kode berdasarkan pilihan singkatan
            // const get_kodekabupaten = () => {
            //     const kabupaten_kota = $('#kabupaten_kota').val();
            //     if (!kabupaten_kota) return;

            //     $.ajax({
            //         url: "{{ route('kecamatan.get_kodekabupaten') }}",
            //         type: 'GET',
            //         data: {
            //             kabupaten_kota
            //         },
            //         success: function(json) {
            //             console.log(json.data);
            //             $('#kode').val(json.nextkode || 0);
            //             console.log('Data diterima:', json);
            //         },
            //         error: function(error) {
            //             console.error('Error fetching kode:', error);
            //         },
            //     });
            // };

            // Panggil fungsi saat ada perubahan pada <select>
            // $('#provinsi').on('change', function() {
            //     get_subkabupaten();
            // });

            // Panggil fungsi saat ada perubahan pada <select>
            // $('#kabupaten_kota').on('change', function() {
            //     get_kodekabupaten();
            // });

            // Panggil fungsi untuk memuat data awal
            get_jenisizin();
        });
    </script>
@endsection
